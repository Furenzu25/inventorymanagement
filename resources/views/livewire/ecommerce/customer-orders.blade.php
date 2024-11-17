<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    <x-nav sticky full-width class="bg-gradient-to-r from-[#401B1B] to-[#72383D] backdrop-blur-md border-b border-[#AB644B]/30 z-50">
        <x-slot:brand>
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                <x-icon name="o-cube-transparent" class="w-12 h-12 text-[#F2F2EB] group-hover:text-[#AB644B] transition-all duration-300" />
                <span class="font-bold text-3xl text-[#F2F2EB] font-['Poppins'] group-hover:text-[#AB644B] transition-all duration-300">
                    Rosels Trading
                </span>
            </a>
        </x-slot:brand>
    </x-nav>

    <div class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white rounded-lg hover:from-[#401B1B] hover:to-[#72383D] transition duration-300 mb-6">
                <x-icon name="o-arrow-left" class="w-5 h-5 mr-2" />
                Back to Home
            </a>

            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                <div class="p-8 sm:p-12">
                    <h1 class="text-3xl font-bold text-[#401B1B] mb-8">My Orders</h1>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#AB644B]/10">
                            <thead class="bg-white/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Order ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Order Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/30 divide-y divide-[#AB644B]/10">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-white/50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-[#401B1B]">
                                            #{{ $order->id }}
                                        </td>
                                        <td class="px-6 py-4 text-[#72383D]">
                                            @foreach($order->preorderItems as $item)
                                                <div class="mb-1">{{ $item->product->product_name }}</div>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-sm
                                                @if($order->status === 'Pending')
                                                    bg-yellow-500/20 text-yellow-700
                                                @elseif($order->status === 'loaned')
                                                    bg-blue-500/20 text-blue-700
                                                @elseif($order->status === 'converted')
                                                    bg-green-500/20 text-green-700
                                                @elseif($order->status === 'Cancelled')
                                                    bg-red-500/20 text-red-700
                                                @else
                                                    bg-gray-500/20 text-gray-700
                                                @endif">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[#72383D]">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-3">
                                                <button wire:click="$set('selectedOrder', {{ $order->id }})"
                                                        class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
                                                    View Details
                                                </button>
                                                
                                                @if($order->status === 'Pending')
                                                    <button wire:click="cancelPreorder({{ $order->id }})"
                                                            onclick="return confirm('Are you sure you want to cancel this order?')"
                                                            class="text-red-600 hover:text-red-800 transition-colors duration-200">
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
        </div>
    </div>
</div>