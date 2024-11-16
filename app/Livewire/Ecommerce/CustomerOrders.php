<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Preorder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function cancelPreorder($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::where('id', $preorderId)
                               ->where('customer_id', Auth::user()->customer->id)
                               ->firstOrFail();
            
            // Only allow cancellation for certain statuses
            if (!in_array($preorder->status, ['Pending', 'approved'])) {
                session()->flash('error', 'This order cannot be cancelled at its current stage.');
                return;
            }   
            
            $preorder->update([
                'status' => 'Cancelled',
                'cancellation_date' => now(),
                'cancelled_by' => 'customer'
            ]);
            
            session()->flash('message', 'Your order has been cancelled successfully.');
        });
    }

    public function cancelOrder($orderId)
    {
        DB::transaction(function () use ($orderId) {
            $order = Preorder::where('id', $orderId)
                            ->where('customer_id', Auth::user()->customer->id)
                            ->firstOrFail();
            
            // Only allow cancellation for pending orders
            if (!in_array($order->status, ['Pending'])) {
                session()->flash('error', 'This order cannot be cancelled at its current stage.');
                return;
            }
            
            $order->update([
                'status' => 'Cancelled',
                'cancelled_at' => now()
            ]);
            
            session()->flash('message', 'Your order has been cancelled successfully.');
        });
    }
} 