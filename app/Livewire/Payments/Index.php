<?php

namespace App\Livewire\Payments;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;
use App\Models\AccountReceivable;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\InventoryItem;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $paymentHistoryOpen = false;
    public $recordPaymentOpen = false;
    public $selectedCustomer = null;
    public $selectedCustomerPayments = [];
    public $payment = [
        'due_amount' => '',
        'amount_paid' => '',
        'payment_date' => ''
    ];
    public $selectedAR = null;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->payment['payment_date'] = date('Y-m-d');
    }

    public function viewPaymentHistory($customerId)
    {
        $this->selectedCustomer = Customer::with(['accountReceivables.preorder.preorderItems.product'])
            ->findOrFail($customerId);
        $this->selectedCustomerPayments = Payment::whereHas('accountReceivable', function($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })->orderBy('payment_date', 'desc')->get();
        
        $this->selectedAR = null;
        $this->paymentHistoryOpen = true;
    }

    public function closePaymentHistory()
    {
        $this->paymentHistoryOpen = false;
        $this->selectedCustomer = null;
        $this->selectedCustomerPayments = [];
    }

    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = Customer::findOrFail($customerId);
        $this->selectedCustomerPayments = Payment::whereHas('accountReceivable', function($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })->orderBy('payment_date', 'desc')->get();
        $this->paymentHistoryOpen = true;
    }

    public function selectAR($arId)
    {
        $this->selectedAR = AccountReceivable::findOrFail($arId);
        $this->selectedCustomerPayments = Payment::where('account_receivable_id', $arId)
            ->orderBy('payment_date', 'desc')
            ->get();
    }

    public function showRecordPayment()
    {
        if (!$this->selectedCustomer) {
            session()->flash('error', 'Please select a customer first.');
            return;
        }

        if (!$this->selectedAR) {
            session()->flash('error', 'Please select an Account Receivable first.');
            return;
        }

        if ($this->selectedAR->status === 'paid') {
            session()->flash('error', 'This Account Receivable is already fully paid.');
            return;
        }

        $this->payment['due_amount'] = $this->selectedAR->monthly_payment;
        $this->payment['amount_paid'] = '';
        $this->payment['payment_date'] = date('Y-m-d');
        
        $this->recordPaymentOpen = true;
    }

    public function closeRecordPayment()
    {
        $this->recordPaymentOpen = false;
        $this->reset('payment');
    }

    public function recordPayment()
    {
        DB::transaction(function () {
            // Create payment record
            $payment = Payment::create([
                'account_receivable_id' => $this->selectedAR->id,
                'amount_paid' => $this->payment['amount_paid'],
                'payment_date' => $this->payment['payment_date'],
                'due_amount' => $this->payment['due_amount'],
                'remaining_balance' => $this->calculatedRemainingBalance
            ]);

            // Update AR balances
            $this->selectedAR->total_paid += $this->payment['amount_paid'];
            $this->selectedAR->remaining_balance -= $this->payment['amount_paid'];
            
            // Check if fully paid
            if ($this->selectedAR->remaining_balance <= 0) {
                $this->selectedAR->status = 'paid';
                
                // Calculate interest earned
                $interestEarned = $this->selectedAR->total_paid - $this->selectedAR->total_amount;
                
                // Create sale record with interest_earned
                Sale::create([
                    'preorder_id' => $this->selectedAR->preorder_id,
                    'customer_id' => $this->selectedAR->customer_id,
                    'account_receivable_id' => $this->selectedAR->id,
                    'total_amount' => $this->selectedAR->total_amount,
                    'interest_earned' => $interestEarned,
                    'payment_method' => 'loan',
                    'completion_date' => now(),
                    'status' => 'completed'
                ]);
                
                // Update inventory item status
                InventoryItem::where('preorder_id', $this->selectedAR->preorder_id)
                    ->update(['status' => 'sold']);
            }
            
            $this->selectedAR->save();

            // Refresh the payment history immediately
            $this->selectedCustomerPayments = Payment::where('account_receivable_id', $this->selectedAR->id)
                ->orderBy('payment_date', 'desc')
                ->get();
        });

        $this->recordPaymentOpen = false;
        $this->reset('payment');
        session()->flash('message', 'Payment recorded successfully.');
        
        // Refresh the component and show payment history
        $this->dispatch('payment-recorded')->to('payments.index');
        $this->paymentHistoryOpen = true;
    }

    public function render()
    {
        $customers = Customer::query()
            ->with(['accountReceivables.preorder.preorderItems.product', 'accountReceivables.payments'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.payments.index', [
            'customers' => $customers
        ]);
    }

    public function getCalculatedRemainingBalanceProperty()
    {
        if (!$this->selectedAR) {
            return 0;
        }
        
        $amountPaid = floatval($this->payment['amount_paid'] ?? 0);
        return $this->selectedAR->remaining_balance - $amountPaid;
    }

    public function getListeners()
    {
        return [
            'refreshComponent' => '$refresh',
            'echo:payment-recorded,PaymentRecorded' => '$refresh'
        ];
    }
}
