<div>
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-gray-500/50 transition-opacity"></div>
            
            <div class="relative bg-white rounded-lg max-w-lg w-full">
                <div class="p-6">
                    <!-- Modal content -->
                    <h3 class="text-lg font-medium mb-4">Add to Cart</h3>
                    
                    @if($product)
                        <!-- Product details -->
                        <div class="mb-4">
                            <h4>{{ $product->product_name }}</h4>
                            <p>Price: ₱{{ number_format($product->price, 2) }}</p>
                        </div>

                        <!-- Quantity selector -->
                        <div class="flex items-center gap-2 mb-4">
                            <button wire:click="decrementQuantity" class="px-2 py-1 bg-gray-200 rounded">-</button>
                            <span>{{ $quantity }}</span>
                            <button wire:click="incrementQuantity" class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>

                        <!-- Add to cart button -->
                        <button wire:click="addToCart" class="w-full bg-blue-500 text-white px-4 py-2 rounded">
                            Add to Cart
                        </button>
                    @endif
                    
                    <!-- Close button -->
                    <button wire:click="closeModal" class="absolute top-4 right-4">
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