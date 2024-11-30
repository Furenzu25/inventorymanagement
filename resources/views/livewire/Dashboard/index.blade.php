<div class="space-y-6">
    <!-- Stats Overview Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat
            value="{{ $customerCount }}"
            icon="o-users"
            class="bg-gradient-to-br from-[#401B1B] to-[#72383D] text-white shadow-lg rounded-lg"
            growth="{{ $newCustomersThisMonth }}"
        >
            <x-slot:title>
                <span class="text-[#F2F2EB] font-semibold">Total Customers</span>
            </x-slot:title>
            <x-slot:subtitle>
                <span class="text-[#F2F2EB]/80 text-sm">+{{ $newCustomersThisMonth }} this month</span>
            </x-slot:subtitle>
        </x-stat>

        <x-stat
            value="{{ $preorderCount }}"
            icon="o-clipboard-document-list"
            class="bg-gradient-to-br from-[#72383D] to-[#AB644B] text-white shadow-lg rounded-lg"
            growth="{{ $preordersThisMonth }}"
        >
            <x-slot:title>
                <span class="text-[#F2F2EB] font-semibold">Total Pre-orders</span>
            </x-slot:title>
            <x-slot:subtitle>
                <span class="text-[#F2F2EB]/80 text-sm">+{{ $preordersThisMonth }} this month</span>
            </x-slot:subtitle>
        </x-stat>

        <x-stat
            value="{{ $productCount }}"
            icon="o-cube"
            class="bg-gradient-to-br from-[#AB644B] to-[#9CABB4] text-white shadow-lg rounded-lg"
            growth="{{ $newProductsThisMonth }}"
        >
            <x-slot:title>
                <span class="text-[#F2F2EB] font-semibold">Total Products</span>
            </x-slot:title>
            <x-slot:subtitle>
                <span class="text-[#F2F2EB]/80 text-sm">+{{ $newProductsThisMonth }} this month</span>
            </x-slot:subtitle>
        </x-stat>

        <x-stat
            value="₱{{ number_format($totalSales, 2) }}"
            icon="o-currency-dollar"
            class="bg-gradient-to-br from-[#9CABB4] to-[#D2DCE6] text-[#401B1B] shadow-lg rounded-lg"
            growth="{{ number_format($salesGrowthRate, 1) }}%"
        >
            <x-slot:title>
                <span class="text-[#401B1B] font-semibold">Total Sales</span>
            </x-slot:title>
            <x-slot:subtitle>
                <span class="text-[#401B1B]/80 text-sm">{{ $salesGrowthRate >= 0 ? '+' : '' }}{{ number_format($salesGrowthRate, 1) }}% from last month</span>
            </x-slot:subtitle>
        </x-stat>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sales Trend Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-[#401B1B]">Sales Trend</h3>
                <div class="text-sm text-[#72383D]">Last 6 months</div>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="salesChart"></canvas>
                @if(empty($salesChartData['data']))
                    <div class="absolute inset-0 flex items-center justify-center text-gray-500">
                        No sales data available
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Products Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-[#401B1B]">Product Distribution</h3>
                <div class="text-sm text-[#72383D]">Top 5 products</div>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="productsChart"></canvas>
                @if(empty($topProductsChartData['data']))
                    <div class="absolute inset-0 flex items-center justify-center text-gray-500">
                        No product data available
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Pre-orders -->
        <x-card class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-[#401B1B]">Recent Pre-orders</h3>
                    <a href="{{ route('preorders.index') }}" class="text-sm text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
                        View All →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                                <th class="text-left font-semibold p-3 rounded-tl-lg">Customer</th>
                                <th class="text-left font-semibold p-3">Products</th>
                                <th class="text-left font-semibold p-3">Amount</th>
                                <th class="text-left font-semibold p-3 rounded-tr-lg">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPreorders as $preorder)
                                <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                    <td class="p-3">
                                        <div class="font-medium text-[#401B1B]">{{ $preorder->customer->name }}</div>
                                        <div class="text-sm text-[#72383D]">#{{ $preorder->id }}</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-[#401B1B] line-clamp-1">
                                            @foreach($preorder->preorderItems as $item)
                                                {{ $item->product->product_name }}
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-[#401B1B] font-medium">₱{{ number_format($preorder->total_amount, 2) }}</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-[#401B1B]">{{ $preorder->order_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-[#72383D]">{{ $preorder->order_date->format('h:i A') }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </x-card>

        <!-- Top Products -->
        <x-card class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-[#401B1B]">Best Selling Products</h3>
                    <a href="{{ route('products.index') }}" class="text-sm text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
                        View All →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white">
                                <th class="text-left font-semibold p-3 rounded-tl-lg">Product</th>
                                <th class="text-left font-semibold p-3">Brand</th>
                                <th class="text-left font-semibold p-3">Revenue</th>
                                <th class="text-left font-semibold p-3 rounded-tr-lg">Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                                <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                    <td class="p-3">
                                        <div class="font-medium text-[#401B1B]">{{ $product->product_name }}</div>
                                    </td>
                                    <td class="p-3 text-[#72383D]">{{ $product->product_brand }}</td>
                                    <td class="p-3">
                                        <div class="text-[#401B1B] font-medium">₱{{ number_format($product->total_sales, 2) }}</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#F2F2EB] text-[#401B1B]">
                                            {{ $product->quantity_sold ?? 0 }} units
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </x-card>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Trend Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($salesChartData['labels'] ?? []),
            datasets: [{
                label: 'Monthly Sales',
                data: @json($salesChartData['data'] ?? []),
                borderColor: '#72383D',
                backgroundColor: 'rgba(114, 56, 61, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Top Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'doughnut',
        data: {
            labels: @json($topProductsChartData['labels'] ?? []),
            datasets: [{
                data: @json($topProductsChartData['data'] ?? []),
                backgroundColor: ['#401B1B', '#72383D', '#AB644B', '#9CABB4', '#D2DCE6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: ${value} units`;
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
});
</script>
@endpush