<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Preorder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $customerCount;
    public $preorderCount;
    public $productCount;
    public $totalSales;
    public $recentPreorders;
    public $topProducts;

    public function mount()
    {
        $this->customerCount = Customer::count();
        $this->preorderCount = Preorder::count();
        $this->productCount = Product::count();
        
        // Calculate total sales
        $this->totalSales = Preorder::sum('total_amount');

        $this->recentPreorders = Preorder::with(['customer', 'preorderItems.product'])
            ->latest('order_date')
            ->take(5)
            ->get();

        $this->topProducts = Product::select('products.*', 
                DB::raw('SUM(preorder_items.quantity) as quantity_sold'),
                DB::raw('SUM(preorder_items.price * preorder_items.quantity) as total_sales'))
            ->leftJoin('preorder_items', 'products.id', '=', 'preorder_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('quantity_sold')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
