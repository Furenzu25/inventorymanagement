<div>
    <x-header title="Sales Management">
        <!-- Removed the Create Sale button from here -->
    </x-header>

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

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <x-input icon="o-magnifying-glass" placeholder="Search sales..." wire:model.live="search" />
                <div class="flex space-x-2">
                    <x-button icon="o-adjustments-horizontal" label="Filter" class="bg-gray-200 hover:bg-gray-300 text-gray-700" />
                    <x-button icon="o-arrows-up-down" label="Sort" class="bg-gray-200 hover:bg-gray-300 text-gray-700" />
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-gray-600">Customer</th>
                            <th class="px-4 py-2 text-left text-gray-600">Product</th>
                            <th class="px-4 py-2 text-left text-gray-600">Monthly Payment</th>
                            <th class="px-4 py-2 text-left text-gray-600">Total Paid</th>
                            <th class="px-4 py-2 text-left text-gray-600">Remaining Balance</th>
                            <th class="px-4 py-2 text-left text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $sale->customer->name }}</td>
                                <td class="px-4 py-3">{{ $sale->preorder->preorderItems->map(function($item) { return $item->product->product_name; })->implode(', ') }}</td>
                                <td class="px-4 py-3">₱{{ number_format($sale->monthly_payment, 2) }}</td>
                                <td class="px-4 py-3">₱{{ number_format($sale->total_paid, 2) }}</td>
                                <td class="px-4 py-3">₱{{ number_format($sale->remaining_balance, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-sm rounded-full {{ $sale->status === 'paid' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('payments.history', $sale->id) }}" class="text-indigo-600 hover:text-indigo-900">View Payment History</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-lg font-semibold mb-4">Convert Preorders to Sales</h2>
        @if($preorders->isNotEmpty())
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-gray-600">Preorder ID</th>
                                <th class="px-4 py-2 text-left text-gray-600">Customer</th>
                                <th class="px-4 py-2 text-left text-gray-600">Total Amount</th>
                                <th class="px-4 py-2 text-left text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preorders as $preorder)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $preorder->id }}</td>
                                    <td class="px-4 py-3">{{ $preorder->customer->name }}</td>
                                    <td class="px-4 py-3">₱{{ number_format($preorder->total_amount, 2) }}</td>
                                    <td class="px-4 py-3">
                                        <x-button wire:click="createSaleFromPreorder({{ $preorder->id }})" class="bg-green-500 hover:bg-green-600 text-white text-xs py-1 px-2 rounded">
                                            Convert to Sale
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p class="text-gray-600">No preorders available for conversion.</p>
        @endif
    </div>
</div>
