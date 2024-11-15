<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Preorder;
use Illuminate\Support\Facades\Auth;

class CustomerOrders extends Component
{
    public $showOrderDetails = false;
    public $selectedOrder = null;
    public $cancellationReason = '';
    public $showCancellationModal = false;
    public $selectedOrderId = null;

    public function render()
    {
        return view('livewire.ecommerce.customer-orders', [
            'orders' => Preorder::where('customer_id', Auth::user()->customer->id)
                              ->with(['preorderItems.product'])
                              ->latest()
                              ->get()
        ])->layout('components.layouts.guest');
    }
} 