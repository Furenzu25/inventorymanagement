<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PaymentSubmission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewPaymentSubmission;
use Illuminate\Support\Facades\DB;

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
    public $showApprovalModal = false;
    public $submissionModalOpen = false;
    public $viewingSubmission = null;
    public $rejectionReason = '';

    protected $rules = [
        'selectedAR' => 'required|exists:account_receivables,id',
        'amount' => 'required|numeric|min:0',
        'paymentProof' => 'required|image|max:5120',
        'paymentDate' => 'required|date',
    ];

    protected $listeners = ['open-payment-modal' => 'openPaymentModal'];

    public function mount()
    {
        $this->accountReceivables = Auth::user()->customer?->accountReceivables ?? collect();
        $this->paymentDate = now()->format('Y-m-d');
    }

    public function openPaymentModal($arId)
    {
        $ar = $this->accountReceivables->find($arId);
        
        if ($ar) {
            $this->selectedAR = $arId;
            $this->dueAmount = $ar->monthly_payment;
            $this->amount = $this->dueAmount;
            $this->paymentDate = now()->format('Y-m-d');
            $this->showModal = true;
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

    public function approveSubmission()
    {
        DB::transaction(function () {
            // ... existing approval code ...
        });

        $this->showApprovalModal = false;
        $this->submissionModalOpen = false;  // Close the submission modal
        $this->viewingSubmission = null;
        
        $this->loadPaymentSubmissions();  // Refresh the submissions list
        $this->refreshStats();
        session()->flash('message', 'Payment has been approved successfully.');
    }

    public function rejectSubmission()
    {
        // Validate the rejection reason
        $this->validate([
            'rejectionReason' => 'required|min:10'
        ]);

        $this->viewingSubmission->update([
            'status' => 'rejected',
            'rejection_reason' => $this->rejectionReason
        ]);
        
        // Notify customer
        $this->viewingSubmission->customer->user->notify(new PaymentRejected($this->viewingSubmission));

        $this->showRejectionModal = false;
        $this->submissionModalOpen = false;  // Close the submission modal
        $this->viewingSubmission = null;
        $this->rejectionReason = ''; // Reset the reason
        
        $this->loadPaymentSubmissions();  // Refresh the submissions list
        session()->flash('message', 'Payment has been rejected.');
    }

    public function render()
    {
        return view('livewire.customers.submit-payment');
    }
}
