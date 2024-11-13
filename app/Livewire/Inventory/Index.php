<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\InventoryItem;
use App\Models\Preorder;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $modalOpen = false;
    public $selectedPreorder = null;
    public $serialNumber = '';
    public $processingPreorder = null;
    
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
        $this->validate();

        DB::transaction(function () {
            $preorder = Preorder::findOrFail($this->selectedPreorder);
            
            // Create inventory item
            $inventoryItem = InventoryItem::create([
                'product_id' => $preorder->preorderItems->first()->product_id,
                'serial_number' => $this->serialNumber,
                'status' => 'reserved',
                'preorder_id' => $preorder->id
            ]);

            // Update preorder status
            $preorder->update(['status' => 'ready_for_pickup']);
            
            // Here you could add notification logic
            // event(new OrderReadyForPickup($preorder));
        });

        $this->modalOpen = false;
        $this->reset(['serialNumber', 'selectedPreorder', 'processingPreorder']);
        session()->flash('message', 'Product added to inventory and marked ready for pickup.');
    }

    public function assignToOrder($inventoryItemId)
    {
        $item = InventoryItem::findOrFail($inventoryItemId);
        $this->selectedPreorder = null;
        $this->openAddModal();
    }

    public function render()
    {
        return view('livewire.inventory.index', [
            'pendingPreorders' => Preorder::where('status', 'approved')
                                        ->whereDoesntHave('inventoryItems')
                                        ->with(['customer', 'preorderItems.product'])
                                        ->get(),
            'inventoryItems' => InventoryItem::with(['product', 'preorder.customer'])
                                           ->latest()
                                           ->get()
        ]);
    }
}
