<div>
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Add to Cart</h3>
                    
                    @if($product)
                        <div class="space-y-6">
                            <!-- Product Details -->
                            <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                                <label class="block text-sm font-semibold text-[#401B1B] mb-2">Product</label>
                                <div class="text-[#72383D]">{{ $product->product_name }}</div>
                            </div>

                            <!-- Price -->
                            <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                                <label class="block text-sm font-semibold text-[#401B1B] mb-2">Price</label>
                                <div class="text-[#72383D] font-medium">₱{{ number_format($product->price, 2) }}</div>
                            </div>

                            <!-- Quantity Selector -->
                            <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                                <label class="block text-sm font-semibold text-[#401B1B] mb-2">Quantity</label>
                                <div class="flex items-center gap-4">
                                    <button 
                                        wire:click="decrementQuantity" 
                                        class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white w-8 h-8 rounded-lg flex items-center justify-center transition duration-300 shadow-md"
                                    >
                                        -
                                    </button>
                                    <span class="text-[#72383D] font-medium text-lg">{{ $quantity }}</span>
                                    <button 
                                        wire:click="incrementQuantity"
                                        class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white w-8 h-8 rounded-lg flex items-center justify-center transition duration-300 shadow-md"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                                <label class="block text-sm font-semibold text-[#401B1B] mb-2">Total Amount</label>
                                <div class="text-[#72383D] font-bold text-lg">
                                    ₱{{ number_format($product->price * $quantity, 2) }}
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <div class="mt-6">
                                <button 
                                    wire:click="addToCart"
                                    wire:loading.attr="disabled"
                                    class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 shadow-md flex items-center justify-center"
                                >
                                    <span wire:loading.remove>Add to Cart</span>
                                    <span wire:loading>Adding to Cart...</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Close Button -->
                    <button 
                        wire:click="closeModal" 
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>