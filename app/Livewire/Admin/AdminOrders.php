<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Preorder;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class AdminOrders extends Component
{
    public $showOrderDetails = false;
    public $selectedOrder = null;
    public $cancellationReason = '';
    public $showCancellationModal = false;
    public $selectedOrderId = null;

    protected $rules = [
        'cancellationReason' => 'required|min:10'
    ];

    public function render()
    {
        return view('livewire.admin.admin-orders', [
            'orders' => Preorder::with(['preorderItems.product', 'customer'])
                              ->latest()
                              ->get()
        ]);
    }

    public function show($orderId)
    {
        $this->selectedOrder = Preorder::where('id', $orderId)
                                     ->where('customer_id', Auth::user()->customer->id)
                                     ->with(['preorderItems.product'])
                                     ->firstOrFail();
        $this->showOrderDetails = true;
    }

    public function cancelPreorder($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::where('id', $preorderId)
                               ->where('customer_id', Auth::user()->customer->id)
                               ->firstOrFail();
            
            // Only allow cancellation for certain statuses
            if (!in_array($preorder->status, ['Pending', 'Approved'])) {
                session()->flash('error', 'This order cannot be cancelled at its current stage.');
                return;
            }
            
            // If there's an inventory item assigned, mark it as available for reassignment
            $inventoryItem = InventoryItem::where('preorder_id', $preorder->id)->first();
            if ($inventoryItem) {
                $inventoryItem->update([
                    'status' => 'available',
                    'preorder_id' => null
                ]);
                
                // Create a notification for admin
                Notification::create([
                    'title' => 'Order Cancelled - Product Available',
                    'message' => "Order #{$preorder->id} was cancelled. Product {$inventoryItem->product->product_name} (SN: {$inventoryItem->serial_number}) is now available for reassignment.",
                    'status' => 'unread',
                    'type' => 'order_cancelled'
                ]);
            }
            
            $preorder->update([
                'status' => 'Cancelled',
                'cancellation_reason' => $this->cancellationReason,
                'cancelled_at' => now()
            ]);
        });
        
        session()->flash('message', 'Your order has been cancelled successfully.');
    }

   
}