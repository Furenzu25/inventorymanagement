<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\InventoryItem;
use App\Models\Preorder;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;

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
        $this->processingPreorder = Preorder::findOrFail($preorderId);
        $this->selectedPreorder = $preorderId;
        $this->openAddModal();
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
            'pendingPreorders' => Preorder::where('status', 'approved')
                                        ->whereDoesntHave('inventoryItems')
                                        ->with(['customer', 'preorderItems.product'])
                                        ->get(),
            'availableItems' => InventoryItem::where('status', 'available')
                                            ->with(['product'])
                                            ->latest()
                                            ->get(),
            'inventoryItems' => InventoryItem::with(['product', 'preorder.customer'])
                                           ->latest()
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
}
