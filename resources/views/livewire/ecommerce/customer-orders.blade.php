<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    @include('livewire.ecommerce.components.nav-bar')
    
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
                                                    bg-yellow-100 text-yellow-800
                                                @elseif($order->status === 'approved')
                                                    bg-blue-100 text-blue-800
                                                @elseif($order->status === 'in_stock')
                                                    bg-indigo-100 text-indigo-800
                                                @elseif($order->status === 'picked_up')
                                                    bg-purple-100 text-purple-800
                                                @elseif($order->status === 'loaned')
                                                    bg-green-100 text-green-800
                                                @elseif($order->status === 'arrived')
                                                    bg-cyan-100 text-cyan-800
                                                @elseif($order->status === 'Cancelled')
                                                    bg-red-100 text-red-800
                                                @elseif($order->status === 'disapproved')
                                                    bg-rose-100 text-rose-800
                                                @elseif($order->status === 'repossessed')
                                                    bg-orange-100 text-orange-800
                                                @elseif($order->status === 'completed')
                                                    bg-emerald-100 text-emerald-800
                                                @else
                                                    bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[#72383D]">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-3">
                                                <button wire:click="viewOrderDetails({{ $order->id }})"
                                                        class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
                                                    View Details
                                                </button>
                                                
                                                @if($order->status === 'Cancelled' || $order->status === 'disapproved')
                                                    <button 
                                                        wire:click="showDisapprovalReason('{{ $order->status === 'Cancelled' ? $order->cancellation_reason : $order->disapproval_reason }}')"
                                                        class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                                    >
                                                        View Reason
                                                    </button>
                                                @endif
                                                
                                                @if(in_array($order->status, ['Pending', 'approved']))
                                                    <button 
                                                        wire:click="openCancellationModal({{ $order->id }})"
                                                        class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
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

    <!-- Order Details Modal -->
    <div x-show="$wire.showOrderDetails" 

         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm " 
                 aria-hidden="true"
                 x-show="$wire.showOrderDetails"
                
                 wire:click="$set('showOrderDetails', false)"></div>

            <div class="inline-block align-bottom bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                @if($orderDetails)
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="text-2xl font-bold text-[#401B1B]">Order Details #{{ $orderDetails->id }}</h3>
                            <button wire:click="$set('showOrderDetails', false)" class="text-[#72383D] hover:text-[#401B1B]">
                                <x-icon name="o-x-mark" class="w-6 h-6" />
                            </button>
                        </div>

                        <!-- Order Status -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-2">
                                <span class="font-semibold text-[#401B1B]">Status:</span>
                                <span class="px-3 py-1 rounded-full text-sm
                                    @if($orderDetails->status === 'Pending')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($orderDetails->status === 'approved')
                                        bg-blue-100 text-blue-800
                                    @elseif($orderDetails->status === 'in_stock')
                                        bg-indigo-100 text-indigo-800
                                    @elseif($orderDetails->status === 'picked_up')
                                        bg-purple-100 text-purple-800
                                    @elseif($orderDetails->status === 'loaned')
                                        bg-green-100 text-green-800
                                    @elseif($orderDetails->status === 'arrived')
                                        bg-cyan-100 text-cyan-800
                                    @elseif($orderDetails->status === 'Cancelled')
                                        bg-red-100 text-red-800
                                    @elseif($orderDetails->status === 'disapproved')
                                        bg-rose-100 text-rose-800
                                    @elseif($orderDetails->status === 'repossessed')
                                        bg-orange-100 text-orange-800
                                    @elseif($orderDetails->status === 'completed')
                                        bg-emerald-100 text-emerald-800
                                    @else
                                        bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($orderDetails->status) }}
                                </span>
                            </div>
                            
                            @if($orderDetails->status === 'disapproved' && $orderDetails->disapproval_reason)
                                <div class="mt-2 p-3 bg-red-50 rounded-lg">
                                    <p class="text-sm font-semibold text-red-700">Disapproval Reason:</p>
                                    <p class="text-sm text-red-600">{{ $orderDetails->disapproval_reason }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Order Information -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-[#72383D]">Order Date</p>
                                <p class="font-semibold text-[#401B1B]">{{ $orderDetails->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-[#72383D]">Payment Method</p>
                                <p class="font-semibold text-[#401B1B]">{{ $orderDetails->payment_method }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-[#72383D]">Loan Duration</p>
                                <p class="font-semibold text-[#401B1B]">{{ $orderDetails->loan_duration }} months</p>
                            </div>
                            <div>
                                <p class="text-sm text-[#72383D]">Interest Rate</p>
                                <p class="font-semibold text-[#401B1B]">{{ $orderDetails->interest_rate }}%</p>
                            </div>
                        </div>

                        <!-- Products -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-[#401B1B] mb-3">Ordered Products</h4>
                            <div class="space-y-3">
                                @foreach($orderDetails->preorderItems as $item)
                                    <div class="flex justify-between items-center p-3 bg-white/50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-[#401B1B]">{{ $item->product->product_name }}</p>
                                            <p class="text-sm text-[#72383D]">Quantity: {{ $item->quantity }}</p>
                                        </div>
                                        <p class="font-semibold text-[#401B1B]">₱{{ number_format($item->price, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="border-t border-[#AB644B]/20 pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[#72383D]">Total Amount:</span>
                                <span class="font-bold text-xl text-[#401B1B]">₱{{ number_format($orderDetails->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[#72383D]">Monthly Payment:</span>
                                <span class="font-semibold text-[#401B1B]">₱{{ number_format($orderDetails->monthly_payment, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reason Modal -->
    @teleport('body')
        <div x-data="{ showReasonModal: @entangle('showReasonModal') }">
            <template x-if="showReasonModal">
                <div class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div class="fixed inset-0 transition-opacity bg-gray-500/30" aria-hidden="true">
                        </div>

                        <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Cancellation Reason</h3>
                                
                                <div class="bg-[#AB644B]/10 p-4 rounded-lg">
                                    <p class="text-[#72383D]">{{ $selectedReason }}</p>
                                </div>
                                
                                <div class="mt-6 flex justify-end">
                                    <button 
                                        @click="showReasonModal = false"
                                        class="px-4 py-2 bg-[#72383D] text-white rounded-lg hover:bg-[#401B1B] transition-colors duration-200"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    @endteleport

    <!-- Cancellation Modal -->
    <div x-data="{ show: @entangle('showCancellationModal') }"
         x-show="show"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm"
                 x-show="show"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-2xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-[#401B1B]">Cancel Order</h2>
                        <button @click="show = false" class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-300">
                            <x-icon name="o-x-mark" class="w-6 h-6" />
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[#401B1B] font-medium mb-2">Reason for Cancellation</label>
                            <textarea
                                wire:model="cancellationReason"
                                class="w-full rounded-lg border-[#AB644B]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 shadow-inner resize-none"
                                rows="4"
                                placeholder="Please provide a reason for cancellation..."
                            ></textarea>
                            @error('cancellationReason')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button 
                                wire:click="$set('showCancellationModal', false)"
                                class="px-4 py-2 bg-[#9CABB4] hover:bg-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                Cancel
                            </button>
                            <button 
                                wire:click="cancelPreorder"
                                class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                Confirm Cancellation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>