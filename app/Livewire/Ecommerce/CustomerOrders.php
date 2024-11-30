<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Preorder;
use App\Traits\WithCartCount;
use App\Traits\WithNotificationCount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class CustomerOrders extends Component
{
    use WithCartCount;
    use WithNotificationCount;
    
    public $showOrderDetails = false;
    public $selectedOrder = null;
    public $orderDetails = null;
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

    public function viewOrderDetails($orderId)
    {
        $this->orderDetails = Preorder::with(['preorderItems.product'])
            ->where('id', $orderId)
            ->where('customer_id', Auth::user()->customer->id)
            ->firstOrFail();
            
        $this->showOrderDetails = true;
    }

    public function cancelPreorder($orderId)
    {
        DB::transaction(function () use ($orderId) {
            $preorder = Preorder::where('id', $orderId)
                ->where('customer_id', Auth::user()->customer->id)
                ->firstOrFail();
            
            // Update to match the statuses shown in the blade template
            if (!in_array($preorder->status, ['Pending', 'approved', 'in_stock', 'arrived'])) {
                session()->flash('error', 'This order cannot be cancelled at its current stage.');
                return;
            }
            
            // Update inventory items if they exist
            if ($preorder->inventoryItems()->exists()) {
                $preorder->inventoryItems()->update([
                    'status' => 'available_for_reassignment',
                    'cancellation_date' => now(),
                    'preorder_id' => null
                ]);
            }
            
            $preorder->update([
                'status' => 'Cancelled',
                'cancellation_date' => now(),
                'cancelled_by' => 'customer',
                'cancellation_reason' => $this->cancellationReason
            ]);

            // Create notification for admin
            DB::table('notifications')->insert([
                'id' => Str::uuid(),
                'type' => 'order_cancelled',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => User::where('is_admin', true)->first()->id,
                'data' => json_encode([
                    'title' => 'Order Cancelled',
                    'message' => "Order #{$preorder->id} has been cancelled by customer {$preorder->customer->name}. Reason: {$this->cancellationReason}",
                    'status' => 'unread',
                    'preorder_id' => $preorder->id
                ]),
                'created_at' => now(),
                'updated_at' => now()
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