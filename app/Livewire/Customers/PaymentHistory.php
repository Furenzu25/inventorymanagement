<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentSubmission;
use App\Models\AccountReceivable;
use App\Traits\WithCartCount;
use App\Traits\WithNotificationCount;

class PaymentHistory extends Component
{
    use WithCartCount, WithNotificationCount;

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