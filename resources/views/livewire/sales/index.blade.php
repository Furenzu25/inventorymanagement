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
            {{ $sale->preorder->preorderItems->map(function($item) { return $item->product->product_name; })->implode(', ') }}
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

        @scope('cell_status', $sale)
            <span class="{{ $sale->status === 'paid' ? 'text-green-500' : 'text-yellow-500' }}">
                {{ ucfirst($sale->status) }}
            </span>
        @endscope

        @scope('cell_actions', $sale)
            <a href="{{ route('payments.history', $sale->id) }}" class="text-indigo-600 hover:text-indigo-900">View Payment History</a>
        @endscope
    </x-table>

    <div class="mt-8">
        <h2 class="text-lg font-semibold mb-4">Convert Preorders to Sales</h2>
        @if($preorders->isNotEmpty())
            <x-table :headers="[
                ['key' => 'id', 'label' => 'Preorder ID'],
                ['key' => 'customer', 'label' => 'Customer'],
                ['key' => 'total_amount', 'label' => 'Total Amount'],
                ['key' => 'actions', 'label' => 'Actions']
            ]" :rows="$preorders">
                @scope('cell_customer', $preorder)
                    {{ $preorder->customer->name }}
                @endscope
                @scope('cell_total_amount', $preorder)
                    {{ number_format($preorder->total_amount, 2) }}
                @endscope
                @scope('cell_actions', $preorder)
                    <x-button wire:click="createSaleFromPreorder({{ $preorder->id }})" class="btn-primary btn-sm">
                        Convert to Sale
                    </x-button>
                @endscope
            </x-table>
        @else
            <p>No preorders available for conversion.</p>
        @endif
    </div>
</div>
