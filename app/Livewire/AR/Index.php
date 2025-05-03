<?php

namespace App\Livewire\AR;

use Livewire\Component;
use App\Models\AccountReceivable;
use App\Models\Preorder;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryItem;
use App\Models\Notification;

class Index extends Component
{
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    public $headers = [
        ['key' => 'customer', 'label' => 'Customer'],
        ['key' => 'product', 'label' => 'Product'],
        ['key' => 'monthly_payment', 'label' => 'Monthly Payment'],
        ['key' => 'total_paid', 'label' => 'Total Paid'],
        ['key' => 'remaining_balance', 'label' => 'Remaining Balance'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'actions', 'label' => 'Actions'],
    ];

    public function render()
    {
        $accountReceivables = AccountReceivable::with(['preorder.preorderItems.product', 'customer'])
            ->when($this->search, function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get()
            ->map(function ($ar) {
                // Update status to 'completed' if remaining balance is 0
                if ($ar->remaining_balance <= 0 && $ar->status !== 'defaulted') {
                    $ar->update(['status' => 'completed']);
                }
                return $ar;
            });

        $totalAR = $accountReceivables->sum('total_paid');
        $totalOutstanding = $this->getTotalOutstandingProperty();

        return view('livewire.AR.index', [
            'accountReceivables' => $accountReceivables,
            'totalAR' => $totalAR,
            'totalOutstanding' => $totalOutstanding,
        ]);
    }

    public function store()
    {
        $validatedData = $this->validate();

        $ar = AccountReceivable::create($validatedData);
        $ar->calculateMonthlyPayment();

        $this->reset();
        session()->flash('message', 'Account Receivable recorded successfully.');
    }

    public function createARFromPreorder(Preorder $preorder)
    {
        DB::transaction(function () use ($preorder) {
            // Debug the preorder monthly payment
            \Log::info('Preorder Monthly Payment: ' . $preorder->monthly_payment);

            $ar = AccountReceivable::create([
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

            // Debug the AR monthly payment after creation
            \Log::info('AR Monthly Payment after creation: ' . $ar->monthly_payment);

            $ar->calculateMonthlyPayment();

            // Debug the AR monthly payment after calculation
            \Log::info('AR Monthly Payment after calculation: ' . $ar->monthly_payment);

            $preorder->update(['status' => 'converted']);

            session()->flash('message', 'Account Receivable created successfully from preorder #' . $preorder->id);
        });
    }

    public function reassignProduct($arId)
    {
        $ar = AccountReceivable::findOrFail($arId);
        
        DB::transaction(function () use ($ar) {
            // Update the inventory item status to repossessed
            $inventoryItem = InventoryItem::where('preorder_id', $ar->preorder_id)->first();
            $inventoryItem->update([
                'status' => 'repossessed',
                'repossessed_at' => now()
            ]);
            
            // Update AR status and clear remaining balance
            $ar->update([
                'status' => 'defaulted',
                'remaining_balance' => 0
            ]);
            
            // Mark the preorder as repossessed
            $ar->preorder->update(['status' => 'repossessed']);

            // Create notification using the correct table structure
            DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'item_repossessed',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => auth()->id(),
                'data' => json_encode([
                    'title' => 'Item Repossessed',
                    'message' => "Product {$inventoryItem->product->product_name} (SN: {$inventoryItem->serial_number}) has been repossessed from {$ar->preorder->customer->name}",
                    'status' => 'unread'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
        
        session()->flash('message', 'Product has been repossessed successfully.');
    }

    public function handleRepossession($accountId)
    {
        DB::transaction(function () use ($accountId) {
            $ar = AccountReceivable::findOrFail($accountId);
            
            // Update inventory items status
            $ar->preorder->inventoryItems()->update([
                'status' => 'repossessed',
                'repossession_date' => now()
            ]);
            
            // Update AR status and clear remaining balance
            $ar->update([
                'status' => 'repossessed',
                'remaining_balance' => 0,  // Clear the remaining balance
                'repossession_date' => now()
            ]);
            
            // Update preorder status
            $ar->preorder->update(['status' => 'repossessed']);
            
            // Create notification
            Notification::create([
                'title' => 'Item Repossessed',
                'message' => "Products from Order #{$ar->preorder->id} have been repossessed from {$ar->preorder->customer->name}",
                'status' => 'unread',
                'type' => 'item_repossessed'
            ]);
        });

        session()->flash('message', 'Item has been repossessed successfully.');
    }

    public function getTotalOutstandingProperty()
    {
        return AccountReceivable::where('status', 'ongoing')  // Only count ongoing ARs
            ->sum(DB::raw('CASE 
                WHEN remaining_balance = 0 THEN 0
                ELSE remaining_balance 
            END'));
    }
}
