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
    ];

    public function render()
    {
        $sales = Sale::with(['customer', 'preorder.product'])->get();

        $totalSales = $sales->sum('total_paid');
        $totalOutstanding = $sales->sum('remaining_balance');

        return view('livewire.sales.index', [
            'sales' => $sales,
            'totalSales' => $totalSales,
            'totalOutstanding' => $totalOutstanding,
        ]);
    }
}