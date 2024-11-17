<div class="p-6 bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6]">
    <x-header title="Dashboard" class="text-[#401B1B] text-3xl font-bold mb-6" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <x-stat
            value="{{ $customerCount }}"
            icon="o-users"
            class="bg-gradient-to-br from-[#401B1B] to-[#72383D] text-white shadow-lg rounded-lg"
        >
            <x-slot:title>
                <span class="text-[#F2F2EB] font-semibold">Total Customers</span>
            </x-slot:title>
        </x-stat>

        <x-stat
            value="{{ $preorderCount }}"
            icon="o-clipboard-document-list"
            class="bg-gradient-to-br from-[#72383D] to-[#AB644B] text-white shadow-lg rounded-lg"
        >
            <x-slot:title>
                <span class="text-[#F2F2EB] font-semibold">Total Pre-orders</span>
            </x-slot:title>
        </x-stat>

        <x-stat
            value="{{ $productCount }}"
            icon="o-cube"
            class="bg-gradient-to-br from-[#AB644B] to-[#9CABB4] text-white shadow-lg rounded-lg"
        >
            <x-slot:title>
                <span class="text-[#F2F2EB] font-semibold">Total Products</span>
            </x-slot:title>
        </x-stat>

        <x-stat
            value="{{ number_format($totalSales, 2) }}"
            icon="o-currency-dollar"
            class="bg-gradient-to-br from-[#9CABB4] to-[#D2DCE6] text-[#401B1B] shadow-lg rounded-lg"
        >
            <x-slot:title>
                <span class="text-[#401B1B] font-semibold">Total Sales</span>
            </x-slot:title>
        </x-stat>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card title="Recent Pre-orders" class="bg-white shadow-md border border-[#9CABB4] rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                            <th class="text-left font-semibold p-3">Customer</th>
                            <th class="text-left font-semibold p-3">Products</th>
                            <th class="text-left font-semibold p-3">Total Amount</th>
                            <th class="text-left font-semibold p-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPreorders as $preorder)
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="text-[#401B1B] p-3">{{ $preorder->customer->name }}</td>
                                <td class="text-[#401B1B] p-3">
                                    @foreach($preorder->preorderItems as $item)
                                        {{ $item->product->product_name }} ({{ $item->quantity }})@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="text-[#401B1B] p-3">{{ number_format($preorder->total_amount, 2) }}</td>
                                <td class="text-[#401B1B] p-3">{{ $preorder->order_date->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
        <x-card title="Top Products" class="bg-white shadow-md border border-[#9CABB4] rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white">
                            <th class="text-left font-semibold p-3">Product</th>
                            <th class="text-left font-semibold p-3">Brand</th>
                            <th class="text-left font-semibold p-3">Price</th>
                            <th class="text-left font-semibold p-3">Quantity Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="text-[#401B1B] p-3">{{ $product->product_name }}</td>
                                <td class="text-[#401B1B] p-3">{{ $product->product_brand }}</td>
                                <td class="text-[#401B1B] p-3">{{ number_format($product->price, 2) }}</td>
                                <td class="text-[#401B1B] p-3">{{ $product->quantity_sold ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>