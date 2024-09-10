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
        
        // Calculate total sales as price * quantity
        $totalSales = Preorder::sum(DB::raw('price * quantity'));

        $recentPreorders = Preorder::with(['customer', 'product'])
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::select('products.*', 
                DB::raw('SUM(preorders.quantity) as quantity_sold'),
                DB::raw('SUM(preorders.price * preorders.quantity) as total_sales'))
            ->leftJoin('preorders', 'products.id', '=', 'preorders.product_id')
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
