<?php

namespace App\Livewire\AR;

use Livewire\Component;
use App\Models\AccountReceivable;
use App\Models\Preorder;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryItem;

class Index extends Component
{
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
        $accountReceivables = AccountReceivable::with(['customer', 'preorder.preorderItems.product'])->get();

        $totalAR = $accountReceivables->sum('total_paid');
        $totalOutstanding = $accountReceivables->sum('remaining_balance');

        $preorders = Preorder::where('status', 'ready_for_pickup')->get();

        return view('livewire.AR.index', [
            'accountReceivables' => $accountReceivables,
            'totalAR' => $totalAR,
            'totalOutstanding' => $totalOutstanding,
            'preorders' => $preorders,
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
            // Free up the inventory item
            $inventoryItem = InventoryItem::where('preorder_id', $ar->preorder_id)->first();
            $inventoryItem->update([
                'status' => 'available',
                'preorder_id' => null
            ]);
            
            // Mark the AR as defaulted
            $ar->update(['status' => 'defaulted']);
            
            // Mark the preorder as repossessed
            $ar->preorder->update(['status' => 'repossessed']);
        });
        
        session()->flash('message', 'Product has been repossessed and is available for reassignment.');
    }
}
