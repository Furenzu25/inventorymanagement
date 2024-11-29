<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentSubmission;
use App\Models\AccountReceivable;
use App\Traits\WithCartCount;
use App\Traits\WithNotificationCount;
use App\Models\User;
use App\Notifications\NewPaymentSubmission;

class PaymentHistory extends Component
{
    use WithCartCount, WithNotificationCount, WithFileUploads;

    public $showPaymentModal = false;
    public $selectedAR;
    public $amount;
    public $paymentProof;
    public $paymentDate;
    public $dueAmount = 0;

    public function openPaymentModal($arId)
    {
        $this->selectedAR = $arId;
        $ar = AccountReceivable::find($arId);
        if ($ar) {
            $this->dueAmount = $ar->monthly_payment;
            $this->amount = $this->dueAmount;
        }
        $this->paymentDate = now()->format('Y-m-d');
        $this->showPaymentModal = true;
    }

    public function submitPayment()
    {
        $this->validate([
            'selectedAR' => 'required|exists:account_receivables,id',
            'amount' => 'required|numeric|min:0',
            'paymentProof' => 'required|image|max:5120',
            'paymentDate' => 'required|date',
        ]);

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

        // Notify admins
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewPaymentSubmission($submission));
        }

        $this->reset(['selectedAR', 'amount', 'paymentProof', 'dueAmount', 'paymentDate']);
        $this->showPaymentModal = false;
        
        session()->flash('message', 'Payment submitted successfully. Your payment is now pending for admin approval.');
        $this->dispatch('refreshNotifications')->to('admin.notification-bell');
    }

    public function render()
    {
        // Get all account receivables for the customer with their payments
        $accountReceivables = AccountReceivable::where('customer_id', Auth::user()->customer->id)
            ->with(['payments' => function($query) {
                $query->orderBy('payment_date', 'desc');
            }, 'preorder.preorderItems.product'])
            ->latest()
            ->get();

        // Get payment submissions separately
        $paymentSubmissions = PaymentSubmission::where('customer_id', Auth::user()->customer->id)
            ->with(['accountReceivable.preorder.preorderItems.product'])
            ->latest()
            ->get();

        return view('livewire.customers.payment-history', [
            'accountReceivables' => $accountReceivables,
            'paymentSubmissions' => $paymentSubmissions
        ])->layout('components.layouts.guest');
    }
} 