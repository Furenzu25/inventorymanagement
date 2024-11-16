<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\InventoryItem;
use App\Models\Preorder;
use App\Models\AccountReceivable;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Notification;

class Index extends Component
{
    public $modalOpen = false;
    public $selectedPreorder = null;
    public $serialNumber = '';
    public $processingPreorder = null;
    public $selectedInventoryItem = null;
    public $availablePreorders = [];
    
    protected $rules = [
        'serialNumber' => 'required|unique:inventory_items,serial_number',
    ];

    public function openAddModal()
    {
        $this->modalOpen = true;
    }

    public function processOrder($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            foreach ($preorder->preorderItems as $item) {
                // Generate unique serial number for each product
                $serialNumber = InventoryItem::generateSerialNumber($item->product_id);
                
                // Create inventory item
                InventoryItem::create([
                    'product_id' => $item->product_id,
                    'serial_number' => $serialNumber,
                    'status' => 'ready_for_pickup',
                    'preorder_id' => $preorder->id
                ]);
            }

            // Update preorder status
            $preorder->update(['status' => 'ready_for_pickup']);
            
            // You can implement notification system here
        });

        session()->flash('message', 'Product(s) processed and serial numbers generated. Ready for pickup.');
    }

    public function addToInventory()
    {
        DB::transaction(function () {
            $preorder = Preorder::findOrFail($this->selectedPreorder);
            
            // Generate serial number automatically
            $serialNumber = InventoryItem::generateSerialNumber();
            
            // Create inventory item
            $inventoryItem = InventoryItem::create([
                'product_id' => $preorder->preorderItems->first()->product_id,
                'serial_number' => $serialNumber,
                'status' => 'reserved',
                'preorder_id' => $preorder->id
            ]);

            // Update preorder status
            $preorder->update(['status' => 'ready_for_pickup']);
        });

        $this->modalOpen = false;
        $this->reset(['selectedPreorder', 'processingPreorder']);
        session()->flash('message', 'Product added to inventory and marked ready for pickup.');
    }

    public function assignToOrder($inventoryItemId)
    {
        $this->selectedInventoryItem = InventoryItem::findOrFail($inventoryItemId);
        
        // Get list of pending preorders that need this product
        $this->availablePreorders = Preorder::where('status', 'Approved')
            ->whereHas('preorderItems', function ($query) use ($inventoryItemId) {
                $query->whereHas('product', function ($q) use ($inventoryItemId) {
                    $q->where('id', $this->selectedInventoryItem->product_id);
                });
            })
            ->whereDoesntHave('inventoryItems')
            ->get();
        
        $this->openAssignModal();
    }

    public function confirmAssignment($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            $this->selectedInventoryItem->update([
                'status' => $preorder->payment_method === 'cash' ? 'sold' : 'reserved',
                'preorder_id' => $preorder->id
            ]);
            
            // If cash payment, directly mark as completed
            if ($preorder->payment_method === 'cash') {
                $preorder->update(['status' => 'completed']);
                
                // Create a direct sale record
                Sale::create([
                    'preorder_id' => $preorder->id,
                    'customer_id' => $preorder->customer_id,
                    'total_amount' => $preorder->total_amount,
                    'payment_method' => 'cash',
                    'completion_date' => now()
                ]);
            } else {
                $preorder->update(['status' => 'ready_for_pickup']);
            }
        });
        
        $this->modalOpen = false;
        session()->flash('message', 'Product processed successfully.');
    }

    public function render()
    {
        return view('livewire.inventory.index', [
            'pendingPreorders' => Preorder::whereIn('status', ['approved', 'in_stock', 'loaned'])
                ->with(['customer', 'preorderItems.product', 'inventoryItems'])
                ->get(),
            'reassignableItems' => InventoryItem::where('status', 'available_for_reassignment')
                ->with(['product', 'preorder.customer'])
                ->get(),
            'repossessedItems' => InventoryItem::where('status', 'repossessed')
                ->with(['product', 'preorder.customer'])
                ->get()
        ]);
    }   

    public function assignAvailableProduct($inventoryItemId, $preorderId)
    {
        DB::transaction(function () use ($inventoryItemId, $preorderId) {
            $inventoryItem = InventoryItem::findOrFail($inventoryItemId);
            $preorder = Preorder::findOrFail($preorderId);
            
            $inventoryItem->update([
                'status' => 'reserved',
                'preorder_id' => $preorder->id
            ]);
            
            $preorder->update(['status' => 'ready_for_pickup']);
            
            session()->flash('message', 'Available product assigned to new pre-order successfully.');
        });
    }

    public function markAsLoaned($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            // Create Account Receivable record
            AccountReceivable::create([
                'preorder_id' => $preorder->id,
                'customer_id' => $preorder->customer_id,
                'monthly_payment' => $preorder->monthly_payment,
                'total_paid' => 0,
                'remaining_balance' => $preorder->total_amount,
                'total_amount' => $preorder->total_amount,
                'payment_months' => $preorder->loan_duration,
                'interest_rate' => $preorder->interest_rate,
                'status' => 'ongoing',
            ]);

            // Update inventory item status
            $inventoryItem = InventoryItem::where('preorder_id', $preorder->id)->first();
            $inventoryItem->update(['status' => 'loaned']);
            
            // Update preorder status
            $preorder->update(['status' => 'loaned']);
        });

        session()->flash('message', 'Order has been marked as loaned and moved to Accounts Receivable.');
    }

    public function stockIn($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            foreach ($preorder->preorderItems as $item) {
                // Generate serial number for bought product
                $serialNumber = InventoryItem::generateSerialNumber($item->product_id);
                
                // Create inventory item
                InventoryItem::create([
                    'product_id' => $item->product_id,
                    'serial_number' => $serialNumber,
                    'status' => 'available',
                    'preorder_id' => $preorder->id
                ]);
            }

            // Update preorder status to indicate product is in stock
            $preorder->update(['status' => 'in_stock']);
            
            // Notify customer that product is ready
            // TODO: Implement notification system
        });

        session()->flash('message', 'Product stocked in successfully.');
    }

    public function processLoan($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            // Create Account Receivable only when customer takes the product
            AccountReceivable::create([
                'preorder_id' => $preorder->id,
                'customer_id' => $preorder->customer_id,
                'monthly_payment' => $preorder->monthly_payment,
                'total_paid' => 0,
                'remaining_balance' => $preorder->total_amount,
                'total_amount' => $preorder->total_amount,
                'payment_months' => $preorder->loan_duration,
                'interest_rate' => $preorder->interest_rate,
                'status' => 'ongoing',
            ]);

            // Update inventory item status to loaned
            $inventoryItem = InventoryItem::where('preorder_id', $preorder->id)->first();
            $inventoryItem->update(['status' => 'loaned']);
            
            // Update preorder status
            $preorder->update(['status' => 'loaned']);
        });

        session()->flash('message', 'Loan processed and product released to customer.');
    }

    public function markAsRepossessed($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            // Update inventory item status
            $inventoryItem = InventoryItem::where('preorder_id', $preorderId)->first();
            if ($inventoryItem) {
                $inventoryItem->update([
                    'status' => 'repossessed',
                    'repossessed_at' => now(),
                ]);
            }
            
            // Update preorder status
            $preorder->update(['status' => 'repossessed']);
            
            // Create notification for admin
            Notification::create([
                'title' => 'Item Repossessed',
                'message' => "Product {$inventoryItem->product->product_name} (SN: {$inventoryItem->serial_number}) has been repossessed from {$preorder->customer->name}",
                'status' => 'unread',
                'type' => 'item_repossessed'
            ]);
        });
        
        session()->flash('message', 'Item marked as repossessed successfully.');
    }

    public function reassignItem($inventoryItemId)
    {
        DB::transaction(function () use ($inventoryItemId) {
            $inventoryItem = InventoryItem::findOrFail($inventoryItemId);
            
            // Clear previous preorder association and update status
            $inventoryItem->update([
                'status' => 'available',
                'preorder_id' => null,
                'repossessed_at' => null // Clear repossession date
            ]);
            
            // Create notification for admin
            Notification::create([
                'title' => 'Item Available for Reassignment',
                'message' => "Product {$inventoryItem->product->product_name} (SN: {$inventoryItem->serial_number}) is now available for reassignment",
                'status' => 'unread',
                'type' => 'item_available'
            ]);
        });
        
        session()->flash('message', 'Item is now available for reassignment.');
    }

    public function handleCancellation($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            // Update inventory items
            $preorder->inventoryItems()->update([
                'status' => 'available_for_reassignment',
                'cancellation_date' => now()
            ]);
            
            // Update preorder status
            $preorder->update(['status' => 'cancelled']);
            
            // Create notification
            NotificationService::itemAvailableForReassignment($preorder);
        });
        
        session()->flash('message', 'Items marked as available for reassignment.');
    }
}
