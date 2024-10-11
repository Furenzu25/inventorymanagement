<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Preorder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public function render()
    {
        $customerCount = Customer::count();
        $preorderCount = Preorder::count();
        $productCount = Product::count();
        
        // Calculate total sales
        $totalSales = Preorder::sum('total_amount');

        $recentPreorders = Preorder::with(['customer', 'preorderItems.product'])
            ->latest('order_date')
            ->take(5)
            ->get();

        $topProducts = Product::select('products.*', 
                DB::raw('SUM(preorder_items.quantity) as quantity_sold'),
                DB::raw('SUM(preorder_items.price * preorder_items.quantity) as total_sales'))
            ->leftJoin('preorder_items', 'products.id', '=', 'preorder_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('quantity_sold')
            ->take(5)
            ->get();

        return view('livewire.dashboard.index', [
            'customerCount' => $customerCount,
            'preorderCount' => $preorderCount,
            'productCount' => $productCount,
            'totalSales' => $totalSales,
            'recentPreorders' => $recentPreorders,
            'topProducts' => $topProducts,
        ]);
    }
}
