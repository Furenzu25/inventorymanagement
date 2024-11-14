<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Preorder;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Orders extends Component
{
    public $showOrderDetails = false;
    public $selectedOrder = null;

    public function render()
    {
        return view('livewire.customers.orders', [
            'orders' => Preorder::where('customer_id', Auth::user()->customer->id)
                              ->with(['preorderItems.product'])
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
            
            // If there's an inventory item assigned, mark it as available
            $inventoryItem = InventoryItem::where('preorder_id', $preorder->id)->first();
            if ($inventoryItem) {
                $inventoryItem->update([
                    'status' => 'in_stock',
                    'preorder_id' => null
                ]);
            }
            
            $preorder->update(['status' => 'Cancelled']);
        });
        
        session()->flash('message', 'Your pre-order has been cancelled successfully.');
    }

   
}