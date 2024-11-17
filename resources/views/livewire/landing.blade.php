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
                <a href="{{ route('login') }}" class="text-[#F2F2EB] hover:text-[#AB644B] transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-1"></i> Login
                </a>
                <a href="{{ route('register') }}" class="bg-[#AB644B] hover:bg-[#72383D] text-white px-4 py-2 rounded-lg transition-all duration-300">
                    <i class="fas fa-user-plus mr-1"></i> Register
                </a>
            </div>
        </x-slot:actions>
    </x-nav>

    <main class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="font-semibold text-5xl text-[#401B1B] leading-tight mb-6">
                    <span class="bg-gradient-to-r from-[#401B1B] via-[#72383D] to-[#AB644B] text-transparent bg-clip-text">
                        Welcome to Rosels Trading
                    </span>
                </h2>
                <p class="text-xl text-[#72383D] mb-8">Discover our premium products and exclusive offers</p>
                <a href="{{ route('register') }}" class="inline-block bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105">
                    Create an Account to Start Shopping
                </a>
            </div>

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
                                                <x-icon name="o-photograph" class="w-16 h-16 text-white" />
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="font-semibold text-[#401B1B] text-xl mb-2">{{ $product->product_name }}</h4>
                                    <p class="text-[#401B1B] font-bold text-2xl mb-3">₱{{ number_format($product->price, 2) }}</p>
                                    <p class="text-[#72383D] mb-4 flex-grow">{{ Str::limit($product->product_description, 100) }}</p>
                                    <div class="mt-auto flex justify-between items-center">
                                        <a href="{{ route('register') }}" 
                                           class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white px-4 py-2 rounded-lg hover:from-[#401B1B] hover:to-[#72383D] transition duration-300 transform hover:scale-105">
                                            Register to Order
                                        </a>
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
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105">
                    Register to Order
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function showProductDetails(productId) {
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
    }

    // Close modal when clicking outside
    document.getElementById('productDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProductDetails();
        }
    });
</script> 