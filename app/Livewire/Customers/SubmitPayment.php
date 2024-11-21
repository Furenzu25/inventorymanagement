<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PaymentSubmission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewPaymentSubmission;

class SubmitPayment extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $selectedAR = '';
    public $amount;
    public $paymentProof;
    public $paymentDate;
    public $accountReceivables;
    public $dueAmount = 0;

    protected $rules = [
        'selectedAR' => 'required|exists:account_receivables,id',
        'amount' => 'required|numeric|min:0',
        'paymentProof' => 'required|image|max:5120',
        'paymentDate' => 'required|date',
    ];

    protected $listeners = [
        'openPaymentModal' => 'openModal'
    ];

    public function mount()
    {
        $this->accountReceivables = Auth::user()->customer?->accountReceivables ?? collect();
        $this->paymentDate = now()->format('Y-m-d');
    }

    public function openModal()
    {
        $this->reset(['selectedAR', 'amount', 'paymentProof', 'dueAmount']);
        $this->showModal = true;
    }

    public function updatedSelectedAR($value)
    {
        if ($value) {
            $ar = $this->accountReceivables->find($value);
            if ($ar) {
                $this->dueAmount = $ar->monthly_payment;
                $this->amount = $this->dueAmount;
            }
        } else {
            $this->dueAmount = 0;
            $this->amount = null;
        }
    }

    public function submitPayment()
    {
        $this->validate();

        $paymentProofPath = $this->paymentProof->store('payment-proofs', 'public');

        $submission = PaymentSubmission::create([
            'customer_id' => Auth::user()->customer->id,
            'account_receivable_id' => $this->selectedAR,
            'amount' => $this->amount,
            'due_amount' => $this->dueAmount,
            'payment_proof' => $paymentProofPath,
            'payment_date' => $this->paymentDate,
            'status' => 'pending',
        ]);

        // Simplified notification sending
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewPaymentSubmission($submission));
        }

        $this->reset(['selectedAR', 'amount', 'paymentProof', 'dueAmount']);
        $this->showModal = false;
        
        session()->flash('message', 'Payment submitted successfully. Your payment is now pending for admin approval.');
        $this->dispatch('refreshNotifications')->to('admin.notification-bell');
        
        return redirect()->route('customer.payments');
    }

    public function render()
    {
        return view('livewire.customers.submit-payment');
    }
}
