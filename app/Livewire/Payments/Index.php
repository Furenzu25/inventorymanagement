<?php

namespace App\Livewire\Payments;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;
use App\Models\AccountReceivable;
use App\Models\Customer;

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
        'payment_date' => '',
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
        if (!$this->selectedAR) {
            session()->flash('error', 'No Account Receivable selected.');
            return;
        }

        $this->validate([
            'payment.amount_paid' => 'required|numeric|min:0',
            'payment.due_amount' => 'required|numeric|min:0',
            'payment.payment_date' => 'required|date'
        ]);

        Payment::create([
            'account_receivable_id' => $this->selectedAR->id,
            'amount_paid' => $this->payment['amount_paid'],
            'payment_date' => $this->payment['payment_date'],
            'due_amount' => $this->payment['due_amount'],
            'remaining_balance' => $this->selectedAR->remaining_balance - $this->payment['amount_paid']
        ]);

        $new_remaining = $this->selectedAR->remaining_balance - $this->payment['amount_paid'];
        $this->selectedAR->update([
            'total_paid' => $this->selectedAR->total_paid + $this->payment['amount_paid'],
            'remaining_balance' => $new_remaining,
            'status' => ($new_remaining <= 0) ? 'paid' : 'pending'
        ]);

        $this->recordPaymentOpen = false;
        $this->reset('payment');
        $this->viewPaymentHistory($this->selectedCustomer->id);
        
        session()->flash('message', 'Payment recorded successfully.');
    }

    public function render()
    {
        $customers = Customer::query()
            ->with('accountReceivables')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.payments.index', [
            'customers' => $customers
        ]);
    }
}
