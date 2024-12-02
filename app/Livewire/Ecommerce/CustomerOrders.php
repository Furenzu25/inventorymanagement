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
use App\Services\NotificationService;

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
    public $showReasonModal = false;
    public $selectedReason = '';

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

    public function openCancellationModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->cancellationReason = '';
        $this->showCancellationModal = true;
    }

    public function cancelPreorder()
    {
        $this->validate([
            'cancellationReason' => 'required|min:10',
        ], [
            'cancellationReason.required' => 'Please provide a reason for cancellation.',
            'cancellationReason.min' => 'The reason must be at least 10 characters.',
        ]);

        DB::transaction(function () {
            $preorder = Preorder::where('id', $this->selectedOrderId)
                               ->where('customer_id', Auth::user()->customer->id)
                               ->firstOrFail();
            
            // Only allow cancellation for pending and approved orders
            if (!in_array($preorder->status, ['Pending', 'approved'])) {
                session()->flash('error', 'Orders cannot be cancelled at this stage.');
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
            
            // Update the preorder status
            $preorder->update([
                'status' => 'Cancelled',
                'cancellation_date' => now(),
                'cancelled_by' => 'customer',
                'cancellation_reason' => $this->cancellationReason
            ]);

            // Create notification for admin about the cancellation
            NotificationService::orderCancelledByCustomer($preorder, $this->cancellationReason);

            session()->flash('message', 'Your order has been cancelled successfully.');
        });

        $this->showCancellationModal = false;
        $this->reset(['cancellationReason', 'selectedOrderId']);
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

    public function showDisapprovalReason($reason)
    {
        $this->selectedReason = $reason;
        $this->showReasonModal = true;
    }
}