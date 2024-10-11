<div class="p-4">
    <x-header title="Dashboard" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <x-stat
            value="{{ $customerCount }}"
            icon="o-users"
            class="bg-gradient-to-br from-red-500 to-red-600 text-white shadow-lg"
        >
            <x-slot:title>
                <span class="text-red-100">Total Customers</span>
            </x-slot:title>
        </x-stat>

        <x-stat
            value="{{ $preorderCount }}"
            icon="o-clipboard-document-list"
            class="bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg"
        >
            <x-slot:title>
                <span class="text-blue-100">Total Pre-orders</span>
            </x-slot:title>
        </x-stat>

        <x-stat
            value="{{ $productCount }}"
            icon="o-cube"
            class="bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg"
        >
            <x-slot:title>
                <span class="text-green-100">Total Products</span>
            </x-slot:title>
        </x-stat>

        <x-stat
            value="{{ number_format($totalSales, 2) }}"
            icon="o-currency-dollar"
            class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white shadow-lg"
        >
            <x-slot:title>
                <span class="text-yellow-100">Total Sales</span>
            </x-slot:title>
        </x-stat>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card title="Recent Pre-orders" class="backdrop-blur-md border border-red-500/30">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left text-white">Customer</th>
                        <th class="text-left text-white">Products</th>
                        <th class="text-left text-white">Total Amount</th>
                        <th class="text-left text-white">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPreorders as $preorder)
                        <tr>
                            <td class="text-white">{{ $preorder->customer->name }}</td>
                            <td class="text-white">
                                @foreach($preorder->preorderItems as $item)
                                    {{ $item->product->product_name }} ({{ $item->quantity }})@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="text-white">{{ number_format($preorder->total_amount, 2) }}</td>
                            <td class="text-white">{{ $preorder->order_date->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-card>
        <x-card title="Top Products" class="bg-black/30 backdrop-blur-md border border-red-500/30">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left text-white">Product</th>
                        <th class="text-left text-white">Brand</th>
                        <th class="text-left text-white">Price</th>
                        <th class="text-left text-white">Quantity Sold</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $product)
                        <tr>
                            <td class="text-white">{{ $product->product_name }}</td>
                            <td class="text-white">{{ $product->product_brand }}</td>
                            <td class="text-white">{{ number_format($product->price, 2) }}</td>
                            <td class="text-white">{{ $product->quantity_sold ?? 0 }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-card>
    </div>
</div>
