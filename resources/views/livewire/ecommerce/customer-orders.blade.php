<div class="min-h-screen bg-gray-900 py-8">
    <!-- Back Button -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-md transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Home
        </a>
    </div>

    <!-- Title -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-white mb-8">My Orders</h1>

        <!-- Orders Table -->
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Order Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-200">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                @foreach($order->preorderItems as $item)
                                    <div class="mb-1">{{ $item->product->product_name }}</div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    @if($order->status === 'Pending')
                                        bg-yellow-500/20 text-yellow-300
                                    @elseif($order->status === 'loaned')
                                        bg-blue-500/20 text-blue-300
                                    @elseif($order->status === 'converted')
                                        bg-green-500/20 text-green-300
                                    @elseif($order->status === 'Cancelled')
                                        bg-red-500/20 text-red-300
                                    @else
                                        bg-gray-500/20 text-gray-300
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-200">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-3">
                                    <button 
                                        wire:click="$set('selectedOrder', {{ $order->id }})"
                                        class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                        View Details
                                    </button>
                                    
                                    @if($order->status === 'Pending')
                                        <button 
                                            wire:click="cancelPreorder({{ $order->id }})"
                                            onclick="return confirm('Are you sure you want to cancel this order?')"
                                            class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                            Cancel Order
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>