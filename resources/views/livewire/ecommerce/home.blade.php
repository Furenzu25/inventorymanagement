<div class="relative z-10">
    <x-nav sticky full-width class="bg-[#2c3e50]/80 backdrop-blur-md border-b border-[#3498db]/30 z-50">
        <x-slot:brand>
            <a href="/" wire:navigate class="flex items-center space-x-2 group">
                <x-icon name="o-cube-transparent" class="w-12 h-12 text-[#3498db] group-hover:animate-spin transition-all duration-300" />
                <span id="brandName" class="font-bold text-3xl text-[#3498db] font-['Poppins'] group-hover:text-[#2ecc71] transition-all duration-300">
                    Rosels Trading
                </span>
            </a>
        </x-slot:brand>
        <x-slot:actions>
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart') }}" class="text-[#3498db] hover:text-[#2ecc71] transition-all duration-300 relative">
                    <x-icon name="o-shopping-cart" class="w-6 h-6" />
                    @if($this->cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-[#3498db] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            {{ $this->cartCount }}
                        </span>
                    @endif
                </a>
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button icon="o-user-circle" class="btn-ghost text-[#3498db] hover:text-[#2ecc71]" />
                    </x-slot:trigger>
                    <x-menu-item title="Edit Profile" icon="o-user-circle" wire:click="$emit('openEditProfileModal')" />
                    <x-menu-item title="Logout" icon="o-arrow-left-on-rectangle" wire:click="logout" />
                </x-dropdown>
            </div>
        </x-slot:actions>
    </x-nav>

    <main class="p-4 sm:p-6 md:p-8">
        <h2 class="font-semibold text-3xl text-gray-200 leading-tight mb-8 text-center">
            {{ __('Welcome to Our Store') }}
        </h2>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-[#2c3e50]/30 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 border-b border-[#3498db]/30">
                        <div class="mt-8 text-2xl text-gray-200">
                            Featured Products
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($products as $product)
                                <div class="border border-[#3498db]/30 p-4 rounded-lg flex flex-col">
                                    <div class="aspect-w-16 aspect-h-9 mb-4">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-contain rounded-lg">
                                        @else
                                            <img src="https://via.placeholder.com/300x200?text=No+Image" alt="{{ $product->product_name }}" class="w-full h-full object-contain rounded-lg">
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-gray-200 text-lg">{{ $product->product_name }}</h3>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-yellow-500">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 fill-current {{ $i <= 4 ? 'text-yellow-500' : 'text-gray-400' }}" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-gray-400 ml-2">(42 reviews)</span>
                                    </div>
                                    <p class="text-gray-400 mt-2">₱{{ number_format($product->price, 2) }}</p>
                                    <p class="text-gray-400 mt-2">{{ Str::limit($product->product_description, 100) }}</p>
                                    <div class="mt-4 flex justify-between items-center">
                                        <x-button wire:click="addToCart({{ $product->id }})" class="bg-[#3498db] hover:bg-[#2980b9] text-white px-4 py-2 rounded transition duration-300">
                                            Add to Cart
                                        </x-button>
                                        <a href="#" class="text-[#3498db] hover:text-[#2ecc71] transition duration-300">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            <!-- Removed "View all products" link -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Product Details Modal -->
    <div id="productDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-gray-900 p-8 rounded-lg max-w-2xl w-full mx-4">
            <h2 id="modalProductTitle" class="text-2xl font-bold text-red-500 mb-4"></h2>
            <div id="modalProductContent" class="text-gray-300"></div>
            <button onclick="closeProductDetails()" class="mt-6 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-300">Close</button>
        </div>
    </div>

    <livewire:user-profile />
</div>

<script>
    function showProductDetails(productId) {
        const modal = document.getElementById('productDetailsModal');
        const title = document.getElementById('modalProductTitle');
        const content = document.getElementById('modalProductContent');

        title.textContent = `Product ${productId} Details`;
        content.innerHTML = `
            <p class="mb-4">Detailed description for Product ${productId}...</p>
            <h3 class="font-bold mb-2">Reviews</h3>
            <div class="mb-4">
                <div class="flex text-yellow-500 mb-1">
                    <x-icon name="s-star" class="w-4 h-4" />
                    <x-icon name="s-star" class="w-4 h-4" />
                    <x-icon name="s-star" class="w-4 h-4" />
                    <x-icon name="s-star" class="w-4 h-4" />
                    <x-icon name="o-star" class="w-4 h-4" />
                </div>
                <p class="text-sm">Great product! Highly recommended.</p>
            </div>
            <h3 class="font-bold mb-2">Product Information</h3>
            <ul class="list-disc list-inside">
                <li>Feature 1</li>
                <li>Feature 2</li>
                <li>Feature 3</li>
            </ul>
        `;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeProductDetails() {
        const modal = document.getElementById('productDetailsModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

