<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Preorder;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

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
        $sales = Sale::with(['customer', 'preorder.preorderItems.product'])->get();

        $totalSales = $sales->sum('total_paid');
        $totalOutstanding = $sales->sum('remaining_balance');

        $preorders = Preorder::where('status', '!=', 'converted')->get();

        return view('livewire.sales.index', [
            'sales' => $sales,
            'totalSales' => $totalSales,
            'totalOutstanding' => $totalOutstanding,
            'preorders' => $preorders,
        ]);
    }

    public function store()
    {
        $validatedData = $this->validate();

        $sale = Sale::create($validatedData);
        $sale->calculateMonthlyPayment();

        $this->reset();
        session()->flash('message', 'Sale recorded successfully.');
    }

    public function createSaleFromPreorder(Preorder $preorder)
    {
        DB::transaction(function () use ($preorder) {
            $sale = Sale::create([
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

            $sale->calculateMonthlyPayment();

            // Update the preorder status to 'converted' or something similar
            $preorder->update(['status' => 'converted']);

            session()->flash('message', 'Sale created successfully from preorder #' . $preorder->id);
        });
    }
}
