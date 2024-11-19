<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    <x-nav sticky full-width class="bg-gradient-to-r from-[#401B1B] to-[#72383D] backdrop-blur-md border-b border-[#AB644B]/30 z-50">
        <x-slot:brand>
            <a href="/" wire:navigate class="flex items-center space-x-2 group">
                <x-icon name="o-cube-transparent" class="w-12 h-12 text-[#F2F2EB] group-hover:text-[#AB644B] transition-all duration-300" />
                <span id="brandName" class="font-bold text-3xl text-[#F2F2EB] font-['Poppins'] group-hover:text-[#AB644B] transition-all duration-300">
                    Rosels Trading
                </span>
            </a>
        </x-slot:brand>
        <x-slot:actions>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('cart') }}" class="text-[#F2F2EB] hover:text-[#AB644B] transition-all duration-300 relative">
                        <x-icon name="o-shopping-cart" class="w-6 h-6" />
                        @if($this->cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-[#AB644B] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                {{ $this->cartCount }}
                            </span>
                        @endif
                    </a>
                    <x-dropdown>
                        <x-slot:trigger>
                            @if(auth()->user()->customer?->profile_image)
                                <img src="{{ Storage::url(auth()->user()->customer->profile_image) }}" 
                                     alt="Profile" 
                                     class="w-8 h-8 rounded-full object-cover border-2 border-[#F2F2EB] hover:border-[#AB644B] transition-all duration-300 cursor-pointer">
                            @else
                                <x-button icon="o-user-circle" class="btn-ghost text-[#F2F2EB] hover:text-[#AB644B]" />
                            @endif
                        </x-slot:trigger>
                        <x-menu-item title="Edit Profile" icon="o-user-circle" wire:click="editProfile" />
                        <x-menu-item title="My Orders" icon="o-shopping-bag" href="{{ route('customer.orders') }}" />
                        <x-menu-item title="Logout" icon="o-arrow-left-on-rectangle" wire:click="logout" />
                    </x-dropdown>
                @endauth
            </div>
        </x-slot:actions>
    </x-nav>

    <main class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-semibold text-5xl text-[#401B1B] leading-tight mb-12 text-center">
                <span class="bg-gradient-to-r from-[#401B1B] via-[#72383D] to-[#AB644B] text-transparent bg-clip-text">
                    {{ __('Welcome!') }}
                </span>
            </h2>

            <div class="py-12">
                <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                    <div class="p-8 sm:p-12">
                        <h3 class="text-3xl font-light text-[#401B1B] mb-8 text-center">Featured Products</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($products as $product)
                                <div class="bg-gradient-to-br from-white to-[#F2F2EB] p-6 rounded-2xl flex flex-col transition-all duration-300 hover:shadow-xl hover:scale-105 group">
                                    <div class="aspect-w-16 aspect-h-9 mb-6 overflow-hidden rounded-xl">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover rounded-xl transition-transform duration-300 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-[#D2DCE6] to-[#9CABB4] flex items-center justify-center rounded-xl">
                                                <x-icon name="o-photo" class="w-16 h-16 text-white" />
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="font-semibold text-[#401B1B] text-xl mb-2">{{ $product->product_name }}</h4>
                                    <div class="flex items-center mb-3">
                                        <div class="flex text-[#AB644B]">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 fill-current {{ $i <= 4 ? 'text-[#AB644B]' : 'text-[#9CABB4]' }}" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        
                                    </div>
                                    <p class="text-[#401B1B] font-bold text-2xl mb-3">₱{{ number_format($product->price, 2) }}</p>
                                    <p class="text-[#72383D] mb-4 flex-grow">{{ Str::limit($product->product_description, 100) }}</p>
                                    <div class="mt-auto flex justify-between items-center">
                                        @auth
                                            <button wire:click="$dispatch('openModal', [{{ $product->id }}])" 
                                                    class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white px-4 py-2 rounded-lg hover:from-[#401B1B] hover:to-[#72383D] transition duration-300 transform hover:scale-105">
                                                Add to Cart
                                            </button>
                                        @endauth
                                        <button onclick="showProductDetails({{ $product->id }})" 
                                                class="text-[#AB644B] hover:text-[#401B1B] transition duration-300 underline">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Product Details Modal -->
    <div id="productDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[60]">
        <div class="bg-white p-8 rounded-2xl max-w-2xl w-full mx-4 shadow-2xl border border-[#AB644B]/20" onclick="event.stopPropagation()">
            <h2 id="modalProductTitle" class="text-3xl font-bold text-[#401B1B] mb-6"></h2>
            <div id="modalProductContent" class="text-[#72383D]"></div>
            <div class="mt-8 flex justify-between items-center">
                <button onclick="closeProductDetails()" class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105">
                    Close
                </button>
                @auth
                    <button onclick="openAddToCartModal(currentProductId)" 
                            class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105">
                        Add to Cart
                    </button>
                @endauth
            </div>
        </div>
    </div>

    @if(!auth()->user()->customer)
        <div class="fixed bottom-4 right-4 bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] border-l-4 border-[#AB644B] text-[#401B1B] p-4 rounded-lg shadow-lg">
            <p class="font-bold mb-1">Profile Incomplete</p>
            <p>Complete your profile to unlock pre-ordering features.</p>
        </div>
    @endif

    <livewire:ecommerce.add-to-cart-modal />
</div>

<script>
    let currentProductId = null;

    function openAddToCartModal(productId) {
        closeProductDetails();
        @this.dispatch('openModal', productId);
    }

    function showProductDetails(productId) {
        currentProductId = productId;
        const modal = document.getElementById('productDetailsModal');
        const title = document.getElementById('modalProductTitle');
        const content = document.getElementById('modalProductContent');

        @this.call('getProductDetails', productId).then(product => {
            title.textContent = product.product_name;
            content.innerHTML = `
                <div class="space-y-6">
                    <div class="mb-6">
                        <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Product Description</h3>
                        <div class="text-[#72383D]">${product.product_description}</div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Product Details</h3>
                        <div class="text-[#72383D] whitespace-pre-line">${product.product_details}</div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Specifications</h3>
                        <ul class="list-disc list-inside text-[#72383D] space-y-2">
                            <li>Model: ${product.product_model}</li>
                            <li>Brand: ${product.product_brand}</li>
                            <li>Storage: ${product.storage_capacity}</li>
                            <li>Category: ${product.product_category}</li>
                        </ul>
                    </div>
                </div>
            `;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    }

    function closeProductDetails() {
        const modal = document.getElementById('productDetailsModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        currentProductId = null;
    }

    // Close modal when clicking outside
    document.getElementById('productDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProductDetails();
        }
    });
</script>