<div>
    <x-header title="Sales Management" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <x-stat
            value="{{ number_format($totalSales, 2) }}"
            icon="o-currency-dollar"
            class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white shadow-lg"
        >
            <x-slot:title>
                <span class="text-yellow-100">Total Sales</span>
            </x-slot:title>
        </x-stat>

        <x-stat
            value="{{ number_format($totalOutstanding, 2) }}"
            icon="o-exclamation-circle"
            class="bg-gradient-to-br from-red-500 to-red-600 text-white shadow-lg"
        >
            <x-slot:title>
                <span class="text-red-100">Total Outstanding</span>
            </x-slot:title>
        </x-stat>
    </div>

    <x-table :headers="$headers" :rows="$sales">
        @scope('cell_customer', $sale)
            {{ $sale->customer->name }}
        @endscope

        @scope('cell_product', $sale)
            {{ $sale->preorder->product->product_name }}
        @endscope

        @scope('cell_monthly_payment', $sale)
            {{ number_format($sale->monthly_payment, 2) }}
        @endscope

        @scope('cell_total_paid', $sale)
            {{ number_format($sale->total_paid, 2) }}
        @endscope

        @scope('cell_remaining_balance', $sale)
            {{ number_format($sale->remaining_balance, 2) }}
        @endscope
    </x-table>
</div>
