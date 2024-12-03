<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\InventoryItem;
use App\Models\Preorder;
use App\Models\AccountReceivable;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Notification;
use Illuminate\Support\Str;
use App\Notifications\StockInCompleted;
use App\Notifications\FirstMonthlyPaymentDue;
use App\Models\CustomerNotification;
use App\Services\NotificationService;

class Index extends Component
{
    public $modalOpen = false;
    public $selectedPreorder = null;
    public $serialNumber = '';
    public $processingPreorder = null;
    public $selectedInventoryItem = null;
    public $availablePreorders = [];
    public $showPickupModal = false;
    public $pickupNotes;
    public $boughtLocation;
    public $boughtDate;
    public $showRecordPickupModal = false;
    public $showPickupDetailsModal = false;
    public $selectedItem = null;
    public $stockedOutItems = [];
    public $showItemDetails = false;
    public $showAssignCustomerModal = false;
    public $showRepossessedDetailsModal = false;
    public $selectedRepossessedItem = null;
    public $newPrice = null;
    public $originalPrice = null;
    public $showCancellationModal = false;
    public $cancellationReason = '';
    public $selectedPreorderId = null;
    
    protected $rules = [
        'serialNumber' => 'required|unique:inventory_items,serial_number',
        'boughtLocation' => 'required',
        'boughtDate' => 'required|date',
    ];

    public function mount()
    {
        $this->stockedOutItems = InventoryItem::with(['preorder.customer', 'product'])
            ->where('status', 'stocked_out')
            ->orderBy('updated_at', 'desc')
            ->get();
        $this->availablePreorders = collect([]);
    }

    public function openAddModal()
    {
        $this->modalOpen = true;
    }

    public function processOrder($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            foreach ($preorder->preorderItems as $item) {
                // Create inventory items based on quantity ordered
                for ($i = 0; $i < $item->quantity; $i++) {
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

                // Create notification for the customer
                DB::table('notifications')->insert([
                    'id' => \Illuminate\Support\Str::uuid(),
                    'type' => 'order_arrived',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id' => $preorder->customer->user_id,
                    'data' => json_encode([
                        'title' => 'Order Arrived',
                        'message' => "Your order for {$item->product->product_name} (Qty: {$item->quantity}) has arrived and is ready for pickup.",
                        'status' => 'unread',
                        'preorder_id' => $preorder->id
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            $preorder->update(['status' => 'arrived']);
        });

        session()->flash('message', 'Order processed successfully. Customer has been notified.');
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
        $this->refreshStockedOutItems();
        
        return view('livewire.inventory.index', [
            'pendingPreorders' => Preorder::whereIn('status', [
                'approved', 
                'in_stock', 
                'picked_up',
                'loaned'
            ])
            ->whereDoesntHave('accountReceivable', function($query) {
                $query->where('remaining_balance', 0)
                    ->where('status', 'completed');
            })
            ->with([
                'customer', 
                'preorderItems.product', 
                'inventoryItems',
                'inventoryItems.pickedUpBy'
            ])
            ->get(),
            'repossessedItems' => InventoryItem::where('status', 'repossessed')
                ->with(['preorder.customer', 'preorder.preorderItems.product'])
                ->get(),
            'reassignableItems' => InventoryItem::where('status', 'available_for_reassignment')
                ->with(['product'])
                ->get(),
            'stockedOutItems' => InventoryItem::with(['preorder.customer', 'product'])
                ->whereHas('preorder.accountReceivable', function($query) {
                    $query->where('remaining_balance', 0)
                        ->where('status', 'completed');
                })
                ->where('status', 'stocked_out')
                ->orderBy('updated_at', 'desc')
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

    public function openStockInModal($preorderId)
    {
        $this->selectedPreorder = Preorder::find($preorderId);
        $this->showPickupModal = true;
    }

    public function stockIn($preorderId)
    {
        try {
            $this->validate([
                'boughtLocation' => 'required|string|min:3',
                'boughtDate' => 'required|date',
            ]);

            DB::transaction(function () use ($preorderId) {
                $preorder = Preorder::findOrFail($preorderId);
                
                foreach ($preorder->preorderItems as $item) {
                    // Create multiple inventory items based on quantity
                    for ($i = 0; $i < $item->quantity; $i++) {
                        $inventoryItem = InventoryItem::create([
                            'product_id' => $item->product_id,
                            'serial_number' => InventoryItem::generateSerialNumber($item->product_id),
                            'status' => 'ready_for_pickup',
                            'preorder_id' => $preorder->id,
                            'bought_location' => $this->boughtLocation,
                            'bought_date' => $this->boughtDate,
                            'notes' => $this->pickupNotes
                        ]);
                    }

                    // Create notification for the customer
                    CustomerNotification::create([
                        'customer_id' => $preorder->customer_id,
                        'title' => 'Order Ready for Pickup',
                        'message' => "Your order for {$item->product->product_name} has arrived and is ready for pickup.",
                        'type' => 'order_arrived'
                    ]);
                }

                $preorder->update(['status' => 'in_stock']);
            });

            $this->showPickupModal = false;
            $this->reset(['pickupNotes', 'boughtLocation', 'boughtDate']);
            session()->flash('message', 'Items have been stocked in successfully and customer has been notified.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error processing stock-in: ' . $e->getMessage());
        }
    }

    public function processLoan($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            // Check if all items have been picked up
            $hasUnpickedItems = $preorder->inventoryItems()
                ->whereNull('picked_up_at')
                ->exists();

            if ($hasUnpickedItems) {
                session()->flash('error', 'All items must be picked up before processing the loan.');
                return;
            }

            $loanStartDate = now();
            $loanEndDate = $loanStartDate->copy()->addMonths($preorder->loan_duration);
            
            // Get the actual price (either override or original)
            $inventoryItem = $preorder->inventoryItems()->first();
            $actualPrice = $inventoryItem->price_override ?? $preorder->total_amount;
            
            // Create Account Receivable with the correct price
            AccountReceivable::create([
                'preorder_id' => $preorder->id,
                'customer_id' => $preorder->customer_id,
                'monthly_payment' => $preorder->monthly_payment,
                'total_paid' => 0,
                'remaining_balance' => $actualPrice,
                'total_amount' => $actualPrice,
                'payment_months' => $preorder->loan_duration,
                'interest_rate' => $preorder->interest_rate,
                'status' => 'ongoing',
                'loan_start_date' => $loanStartDate,
                'loan_end_date' => $loanEndDate,
            ]);

            // Update statuses
            $preorder->update(['status' => 'loaned']);
            $inventoryItem->update(['status' => 'loaned']);

            // Add notification
            NotificationService::loanActivated($preorder);
        });

        session()->flash('message', 'Loan processed successfully. Account Receivable has been created.');
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

    protected function generateVerificationCode(): string
    {
        return strtoupper(Str::random(8));
    }

    public function openPickupModal($itemId)
    {
        $this->selectedInventoryItem = InventoryItem::find($itemId);
        $this->showRecordPickupModal = true;
    }

    public function recordPickup($inventoryItemId)
    {
        try {
            $this->validate([
                'pickupNotes' => 'nullable|string',
            ]);

            DB::transaction(function () use ($inventoryItemId) {
                $inventoryItem = InventoryItem::findOrFail($inventoryItemId);
                
                $inventoryItem->update([
                    'picked_up_at' => now(),
                    'picked_up_by' => auth()->id(),
                    'pickup_verification' => $this->generateVerificationCode(),
                    'pickup_notes' => $this->pickupNotes,
                ]);

                // Only update preorder status if ALL items are picked up
                $allItemsPickedUp = $inventoryItem->preorder->inventoryItems()
                    ->whereNull('picked_up_at')
                    ->count() === 0;

                if ($allItemsPickedUp) {
                    $inventoryItem->preorder->update(['status' => 'picked_up']);
                }
            });

            $this->showRecordPickupModal = false;
            $this->reset(['pickupNotes']);
            $this->dispatch('refresh')->self();
            
            session()->flash('message', 'Pickup details recorded successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error recording pickup: ' . $e->getMessage());
        }
    }

    public function showPickupDetails($preorderId)
    {
        $this->selectedPreorder = Preorder::with(['inventoryItems.product', 'inventoryItems.pickedUpBy'])
            ->findOrFail($preorderId);
        $this->showPickupDetailsModal = true;
    }

    public function refreshStockedOutItems()
    {
        // First, update any inventory items that should be stocked out
        DB::transaction(function () {
            // Find all inventory items with completed account receivables
            $completedItems = InventoryItem::whereHas('preorder.accountReceivable', function($query) {
                $query->where('remaining_balance', 0)
                    ->where('status', 'completed');
            })
            ->where('status', 'loaned')
            ->get();

            // Update their status to stocked out
            foreach ($completedItems as $item) {
                $item->update([
                    'status' => 'stocked_out',
                    'stocked_out_at' => now()
                ]);

                // Create notification
                NotificationService::itemStockedOut($item);
            }
        });

        // Then refresh the stockedOutItems property
        $this->stockedOutItems = InventoryItem::with(['preorder.customer', 'product'])
            ->whereHas('preorder.accountReceivable', function($query) {
                $query->where('remaining_balance', 0)
                    ->where('status', 'completed');
            })
            ->where('status', 'stocked_out')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function viewItemDetails($itemId)
    {
        $this->selectedItem = InventoryItem::with(['product'])
            ->findOrFail($itemId);
        
        // Initialize availablePreorders as a collection
        $this->availablePreorders = Preorder::where('status', 'Approved')
            ->whereHas('preorderItems', function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('id', $this->selectedItem->product_id);
                });
            })
            ->whereDoesntHave('inventoryItems')
            ->get();
        
        $this->showItemDetails = true;
    }

    public function openAssignModal($itemId)
    {
        $this->selectedItem = InventoryItem::with(['product'])->find($itemId);
        $this->originalPrice = $this->selectedItem->product->price;
        $this->newPrice = $this->originalPrice; // Default to original price
        
        // Get only preorders that match the product type
        $this->availablePreorders = Preorder::with('customer')
            ->whereHas('preorderItems', function ($query) {
                $query->where('product_id', $this->selectedItem->product_id);
            })
            ->where('status', 'approved')
            ->get();
        
        // Close the Repossessed Details Modal
        $this->showRepossessedDetailsModal = false;

        $this->showAssignCustomerModal = true;
    }

    public function selectItemForAssignment($itemId)
    {
        $this->selectedItem = InventoryItem::with(['product', 'preorder.customer'])->find($itemId);
        $this->showAssignCustomerModal = true;
    }

    public function assignToCustomer($preorderId)
    {
        try {
            $this->validate([
                'newPrice' => 'required|numeric|min:0',
            ]);

            DB::transaction(function () use ($preorderId) {
                $preorder = Preorder::findOrFail($preorderId);
                
                // Update preorder item with new price
                $preorderItem = $preorder->preorderItems()
                    ->where('product_id', $this->selectedItem->product_id)
                    ->first();
                    
                if ($preorderItem) {
                    // Update the preorder item with new price
                    $preorderItem->update([
                        'unit_price' => $this->newPrice,
                        'total_price' => $this->newPrice * $preorderItem->quantity
                    ]);
                    
                    // Update the main preorder total and recalculate monthly payment
                    $totalAmount = $this->newPrice * $preorderItem->quantity;
                    $monthlyPayment = $this->calculateMonthlyPayment(
                        $totalAmount,
                        $preorder->loan_duration,
                        $preorder->interest_rate
                    );
                    
                    $preorder->update([
                        'total_amount' => $totalAmount,
                        'monthly_payment' => $monthlyPayment
                    ]);
                }
                
                // Update inventory item
                $this->selectedItem->update([
                    'status' => 'in_stock',
                    'preorder_id' => $preorder->id,
                    'repossession_date' => null,
                    'cancellation_date' => null,
                    'price_override' => $this->newPrice,
                    'picked_up_at' => null
                ]);
                
                $preorder->update(['status' => 'in_stock']);
                
                // Create notification
                CustomerNotification::create([
                    'customer_id' => $preorder->customer_id,
                    'title' => 'Item Ready for Pickup',
                    'message' => "Your order for {$this->selectedItem->product->product_name} is ready for pickup.",
                    'type' => 'order_arrived'
                ]);
            });
            
            $this->showAssignCustomerModal = false;
            $this->reset(['newPrice', 'originalPrice']);
            session()->flash('message', 'Item successfully assigned to customer. Please record pickup before processing loan.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error assigning item: ' . $e->getMessage());
        }
    }

    private function calculateMonthlyPayment($totalAmount, $loanDuration, $interestRate)
    {
        // Calculate total interest amount
        $totalInterest = $totalAmount * ($interestRate / 100);
        
        // Calculate fixed monthly payment (principal + interest)
        $monthlyPayment = ($totalAmount + $totalInterest) / $loanDuration;
        
        return round($monthlyPayment, 2);
    }

    public function viewRepossessedDetails($itemId)
    {
        $this->selectedRepossessedItem = InventoryItem::with(['product', 'preorder.customer'])
            ->findOrFail($itemId);
        $this->showRepossessedDetailsModal = true;
    }

    public function openCancellationModal($preorderId)
    {
        $this->selectedPreorderId = $preorderId;
        $this->cancellationReason = '';
        $this->showCancellationModal = true;
    }

    public function cancelOrder()
    {
        $this->validate([
            'cancellationReason' => 'required|min:10',
        ], [
            'cancellationReason.required' => 'Please provide a reason for cancellation.',
            'cancellationReason.min' => 'The reason must be at least 10 characters.',
        ]);

        DB::transaction(function () {
            $preorder = Preorder::findOrFail($this->selectedPreorderId);
            
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
                'cancelled_by' => 'admin',
                'cancellation_reason' => $this->cancellationReason
            ]);

            // Get all product names
            $productNames = $preorder->preorderItems->map(function ($item) {
                return $item->product->product_name;
            })->join(', ');

            // Create notification for customer
            CustomerNotification::create([
                'customer_id' => $preorder->customer_id,
                'title' => 'Order Cancelled',
                'message' => "Your order for the following products: {$productNames} has been cancelled by the administrator. Reason: {$this->cancellationReason}",
                'type' => 'order_cancelled'
            ]);
        });

        $this->showCancellationModal = false;
        $this->reset(['cancellationReason', 'selectedPreorderId']);
        session()->flash('message', 'Order has been cancelled successfully.');
    }
}
