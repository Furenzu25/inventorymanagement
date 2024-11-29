<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Customer Orders</h2>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">Order ID</th>
                    <th class="px-4 py-2 text-left">Customer</th>
                    <th class="px-4 py-2 text-left">Product</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Order Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2">#{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->customer->name }}</td>
                        <td class="px-4 py-2">
                            @foreach($order->preorderItems as $item)
                                {{ $item->product->product_name }}<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">{{ $order->status }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="show({{ $order->id }})" 
                                    class="text-blue-600 hover:text-blue-800">
                                View Details
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>