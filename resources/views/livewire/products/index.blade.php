<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    @if (session()->has('message'))
        <div class="bg-[#72383D] text-white p-4 rounded-lg mb-6">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-[#AB644B] text-white p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <x-header title="Products" class="text-[#401B1B] text-3xl font-bold" />
        <div class="flex space-x-2 mt-4 md:mt-0">
            <x-input 
                icon="o-magnifying-glass" 
                placeholder="Search products..." 
                wire:model.live="search" 
                class="pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-md shadow-sm"
            />
            <x-button 
                label="Create Product" 
                wire:click="create" 
                class="bg-[#72383D] hover:bg-[#401B1B] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out" 
            />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($products as $product)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
                <div class="h-48 bg-[#F2F2EB] flex items-center justify-center">
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-contain">
                    @else
                        <img src="{{ asset('storage/uploads/default-image.jpg') }}" alt="Default Image" class="w-full h-full object-contain">
                    @endif
                </div>
                <div class="p-4 flex-grow bg-gradient-to-b from-white to-[#D2DCE6]">
                    <h2 class="text-lg font-semibold text-[#401B1B]">{{ $product->product_name }}</h2>
                    <p class="text-xl font-bold mt-2 text-[#72383D]">₱{{ number_format($product->price, 2) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <x-button 
                            label="View Details" 
                            wire:click="showProductDetails({{ $product->id }})" 
                            class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300"
                        />
                        <x-button 
                            icon="o-pencil" 
                            wire:click="edit({{ $product->id }})" 
                            class="btn-icon btn-xs bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300"
                        />
                        <x-button 
                            icon="o-trash" 
                            wire:click="delete({{ $product->id }})" 
                            wire:confirm="Are you sure?" 
                            spinner 
                            class="btn-icon btn-xs bg-[#AB644B] hover:bg-[#72383D] text-white transition duration-300"
                        />
                    </div>
                </div>
            </div>
        @endforeach
    </div>  

    {{ $products->links() }}

    <div x-data="{ open: @entangle('modalOpen') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity" @click="open = false"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-4xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">{{ $productId ? 'Edit Product' : 'Create Product' }}</h3>
                    
                    <form wire:submit.prevent="store">
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <x-input label="Product Name" wire:model="product.product_name" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Model" wire:model="product.product_model" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Brand" wire:model="product.product_brand" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Category" wire:model="product.product_category" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Price" type="number" step="0.01" wire:model="product.price" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <x-select
                                    label="Storage Capacity"
                                    wire:model="product.storage_capacity"
                                    :options="[
                                        ['name' => '64GB', 'value' => '64GB'],
                                        ['name' => '128GB', 'value' => '128GB'],
                                        ['name' => '256GB', 'value' => '256GB'],
                                        ['name' => '512GB', 'value' => '512GB'],
                                        ['name' => '1TB', 'value' => '1TB']
                                    ]"
                                    option-label="name"
                                    option-value="value"
                                    placeholder="Select Storage Capacity"
                                    class="w-full bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                />
                                
                                <x-input label="Description" wire:model="product.product_description" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                
                                <x-textarea 
                                    label="Product Details"
                                    wire:model="product.product_details"
                                    placeholder="Enter detailed product information, features, specifications, etc."
                                    class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                />

                                <div class="space-y-2">
                                    <x-file 
                                        wire:model="image" 
                                        label="Product Image"
                                        accept="image/png, image/jpeg, image/jpg, image/gif"
                                        hint="Upload image (max 5MB)"
                                    >
                                        <x-slot:preview>
                                            @if ($image && !$errors->has('image'))
                                                <img src="{{ $image->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-lg" />
                                            @elseif ($existingImage)
                                                <img src="{{ Storage::url($existingImage) }}" class="h-32 w-32 object-cover rounded-lg" />
                                            @else
                                                <div class="h-32 w-32 rounded-lg bg-[#1A1B1E] flex items-center justify-center">
                                                    <x-icon name="o-photo" class="w-8 h-8 text-gray-400" />
                                                </div>
                                            @endif
                                        </x-slot:preview>
                                    </x-file>
                                    
                                    @error('image') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <x-button type="button" wire:click="closeModal" class="bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300">Cancel</x-button>
                            <x-button type="submit" class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300">Save</x-button>
                        </div>
                    </form>

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

    <div x-data="{ open: @entangle('productDetailsOpen') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity" @click="open = false"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-4xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    @if($selectedProduct)
                        <!-- Header -->
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-[#401B1B]">{{ $selectedProduct->product_name }}</h2>
                            <div class="h-0.5 bg-[#72383D]/20 mt-2"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column - Product Image -->
                            <div>
                                <div class="bg-white p-4 rounded-lg shadow-md">
                                    @if ($selectedProduct->image)
                                        <img src="{{ Storage::url($selectedProduct->image) }}" 
                                             alt="{{ $selectedProduct->product_name }}" 
                                             class="w-full h-auto rounded-lg shadow-sm">
                                    @else
                                        <img src="{{ asset('storage/uploads/default-image.jpg') }}" 
                                             alt="Default Image" 
                                             class="w-full h-auto rounded-lg shadow-sm">
                                    @endif
                                </div>
                                
                                <!-- Price Card -->
                                <div class="mt-4 bg-[#72383D] text-white p-4 rounded-lg shadow-md">
                                    <div class="text-center">
                                        <p class="text-sm uppercase">Price</p>
                                        <p class="text-2xl font-bold">₱{{ number_format($selectedProduct->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Product Details -->
                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div class="bg-white/50 p-4 rounded-lg shadow-md">
                                    <h3 class="font-bold text-lg mb-3 text-[#401B1B]">Product Information</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <div><span class="text-[#401B1B] font-medium">Model:</span> <span class="text-[#72383D]">{{ $selectedProduct->product_model }}</span></div>
                                            <div><span class="text-[#401B1B] font-medium">Brand:</span> <span class="text-[#72383D]">{{ $selectedProduct->product_brand }}</span></div>
                                            <div><span class="text-[#401B1B] font-medium">Category:</span> <span class="text-[#72383D]">{{ $selectedProduct->product_category }}</span></div>
                                        </div>
                                        <div class="space-y-2">
                                            <div><span class="text-[#401B1B] font-medium">Storage:</span> <span class="text-[#72383D]">{{ $selectedProduct->storage_capacity }}</span></div>
                                            <div><span class="text-[#401B1B] font-medium">Created:</span> <span class="text-[#72383D]">{{ $selectedProduct->created_at->format('M d, Y') }}</span></div>
                                            <div><span class="text-[#401B1B] font-medium">Updated:</span> <span class="text-[#72383D]">{{ $selectedProduct->updated_at->format('M d, Y') }}</span></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="bg-white/50 p-4 rounded-lg shadow-md">
                                    <h3 class="font-bold text-lg mb-3 text-[#401B1B]">Description</h3>
                                    <p class="text-[#72383D] leading-relaxed">{{ $selectedProduct->product_description }}</p>
                                </div>

                                <!-- Detailed Specifications -->
                                <div class="bg-white/50 p-4 rounded-lg shadow-md">
                                    <h3 class="font-bold text-lg mb-3 text-[#401B1B]">Detailed Specifications</h3>
                                    <div class="text-[#72383D] whitespace-pre-line leading-relaxed">{{ $selectedProduct->product_details }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-6 flex justify-end">
                            <x-button 
                                label="Close" 
                                wire:click="$set('productDetailsOpen', false)" 
                                class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300" 
                            />
                        </div>
                    @endif

                    <!-- Close Button -->
                    <button 
                        wire:click="$set('productDetailsOpen', false)"
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
</div>