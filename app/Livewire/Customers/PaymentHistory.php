<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentSubmission;
use App\Traits\WithCartCount;
use App\Traits\WithNotificationCount;

class PaymentHistory extends Component
{
    use WithCartCount, WithNotificationCount;

    public function render()
    {
        $paymentSubmissions = PaymentSubmission::where('customer_id', Auth::user()->customer->id)
            ->with(['accountReceivable.preorder.preorderItems.product'])
            ->latest()
            ->get();

        return view('livewire.customers.payment-history', [
            'paymentSubmissions' => $paymentSubmissions
        ])->layout('components.layouts.guest');
    }
} 