<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Preorder;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    public $customerCount;
    public $preorderCount;
    public $productCount;
    public $totalSales;
    public $recentPreorders;
    public $topProducts;
    public $newCustomersThisMonth;
    public $preordersThisMonth;
    public $newProductsThisMonth;
    public $salesGrowthRate;
    public $salesChartData;
    public $topProductsChartData;

    public function mount()
    {
        // Basic counts
        $this->customerCount = Customer::count();
        $this->preorderCount = Preorder::count();
        $this->productCount = Product::count();
        
        // Monthly statistics
        $this->newCustomersThisMonth = Customer::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $this->preordersThisMonth = Preorder::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $this->newProductsThisMonth = Product::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Sales calculations
        $this->totalSales = Sale::sum('total_amount');
        
        $lastMonthSales = Sale::whereMonth('completion_date', now()->subMonth()->month)
            ->whereYear('completion_date', now()->subMonth()->year)
            ->sum('total_amount');
            
        $thisMonthSales = Sale::whereMonth('completion_date', now()->month)
            ->whereYear('completion_date', now()->year)
            ->sum('total_amount');
            
        $this->salesGrowthRate = $lastMonthSales > 0 
            ? (($thisMonthSales - $lastMonthSales) / $lastMonthSales) * 100 
            : 0;

        // Recent preorders
        $this->recentPreorders = Preorder::with(['customer', 'preorderItems.product'])
            ->latest('order_date')
            ->take(5)
            ->get();

        // Top products
        $this->topProducts = Product::select('products.*', 
                DB::raw('SUM(preorder_items.quantity) as quantity_sold'),
                DB::raw('SUM(s.total_amount) as total_sales'))
            ->leftJoin('preorder_items', 'products.id', '=', 'preorder_items.product_id')
            ->leftJoin('preorders as p', 'preorder_items.preorder_id', '=', 'p.id')
            ->leftJoin('sales as s', 'p.id', '=', 's.preorder_id')
            ->groupBy('products.id')
            ->orderByDesc('quantity_sold')
            ->take(5)
            ->get();

        // Prepare chart data
        $this->prepareSalesChartData();
        $this->prepareTopProductsChartData();
    }

    private function prepareSalesChartData()
    {
        $salesData = Sale::select(
            DB::raw('COALESCE(SUM(total_amount), 0) as total'),
            DB::raw('DATE_FORMAT(completion_date, "%Y-%m") as month')
        )
            ->where('completion_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $this->salesChartData = [
            'labels' => $salesData->pluck('month')->map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('M Y');
            })->toArray(),
            'data' => $salesData->pluck('total')->map(function($total) {
                return (float) $total;
            })->toArray()
        ];
    }

    private function prepareTopProductsChartData()
    {
        $topProductsData = Product::select(
                'products.product_name',
                DB::raw('COALESCE(SUM(preorder_items.quantity), 0) as quantity_sold')
            )
            ->leftJoin('preorder_items', 'products.id', '=', 'preorder_items.product_id')
            ->leftJoin('preorders as p', 'preorder_items.preorder_id', '=', 'p.id')
            ->leftJoin('sales as s', 'p.id', '=', 's.preorder_id')
            ->groupBy('products.id', 'products.product_name')
            ->orderByDesc('quantity_sold')
            ->take(5)
            ->get();

        $this->topProductsChartData = [
            'labels' => $topProductsData->pluck('product_name')->toArray(),
            'data' => $topProductsData->pluck('quantity_sold')->map(function($qty) {
                return (int) $qty;
            })->toArray()
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
