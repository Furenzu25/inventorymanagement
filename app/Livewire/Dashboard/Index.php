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
        $totalSales = Preorder::sum('price');

        $recentPreorders = Preorder::with(['customer', 'product'])
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::select('products.*', DB::raw('COUNT(preorders.id) as order_count'))
            ->leftJoin('preorders', 'products.id', '=', 'preorders.product_id')
            ->groupBy('products.id')
            ->orderByDesc('order_count')
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