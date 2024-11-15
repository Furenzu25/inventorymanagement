<div class="min-h-screen bg-[#1a1a1a] text-gray-300 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-[#3498db] mb-8">My Orders</h2>
        
        <div class="bg-[#2c3e50] rounded-lg shadow-lg overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#3498db]/30">
                        <th class="px-6 py-3 text-left">Order ID</th>
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Order Date</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b border-[#3498db]/10 hover:bg-[#34495e] transition-all duration-200">
                            <td class="px-6 py-4">#{{ $order->id }}</td>
                            <td class="px-6 py-4">
                                @foreach($order->preorderItems as $item)
                                    {{ $item->product->product_name }}<br>
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    {{ $order->status === 'Pending' ? 'bg-yellow-500/20 text-yellow-300' : 
                                       ($order->status === 'Completed' ? 'bg-green-500/20 text-green-300' : 
                                        'bg-red-500/20 text-red-300') }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <button wire:click="$set('selectedOrder', {{ $order->id }})" 
                                        class="text-[#3498db] hover:text-[#2ecc71] transition-all duration-300">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>