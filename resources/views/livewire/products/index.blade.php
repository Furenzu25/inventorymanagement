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

    <x-header title="Products" class="text-[#401B1B] text-3xl font-bold mb-6">
        <x-slot:actions>
            <x-button label="Create Product" wire:click="create" class="bg-[#72383D] hover:bg-[#401B1B] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out" />
        </x-slot:actions>
    </x-header>

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
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">{{ $productId ? 'Edit Product' : 'Create Product' }}</h3>
                    
                    <form wire:submit.prevent="store">
                        <div class="space-y-4">
                            <x-input label="Product Name" wire:model="product.product_name" />
                            <x-input label="Model" wire:model="product.product_model" />
                            <x-input label="Brand" wire:model="product.product_brand" />
                            <x-input label="Category" wire:model="product.product_category" />
                            <x-input label="Description" wire:model="product.product_description" />
                            <x-input label="Price" type="number" step="0.01" wire:model="product.price" />
                            <div class="space-y-2">
                                <x-file 
                                    wire:model="image" 
                                    label="Product Image"
                                    accept="image/png, image/jpeg, image/jpg, image/gif"
                                    hint="Upload image (max 5MB)"
                                >
                                    <x-slot:preview>
                                        @if ($image && $imageUploaded)
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
                                
                                @if ($imageUploaded)
                                    <p class="text-sm text-[#72383D]">New image uploaded. Save to apply changes.</p>
                                @endif
                            </div>
                            
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
                                class="w-full"
                            />
                            @error('product.storage_capacity') 
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            <x-textarea 
                                label="Product Details"
                                wire:model="product.product_details"
                                placeholder="Enter detailed product information, features, specifications, etc."
                                
                            />
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
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    
                    
                    @if($selectedProduct)
                        <div class="space-y-4">
                            <div class="mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Product Information</h3>
                                        <div class="space-y-2">
                                            <div><strong class="text-[#401B1B]">Name:</strong> <span class="text-[#72383D]">{{ $selectedProduct->product_name }}</span></div>
                                            <div><strong class="text-[#401B1B]">Price:</strong> <span class="text-[#72383D]">₱{{ number_format($selectedProduct->price, 2) }}</span></div>
                                            <div><strong class="text-[#401B1B]">Model:</strong> <span class="text-[#72383D]">{{ $selectedProduct->product_model }}</span></div>
                                            <div><strong class="text-[#401B1B]">Brand:</strong> <span class="text-[#72383D]">{{ $selectedProduct->product_brand }}</span></div>
                                            <div><strong class="text-[#401B1B]">Category:</strong> <span class="text-[#72383D]">{{ $selectedProduct->product_category }}</span></div>
                                            <div><strong class="text-[#401B1B]">Storage:</strong> <span class="text-[#72383D]">{{ $selectedProduct->storage_capacity }}</span></div>
                                            <div><strong class="text-[#401B1B]">Description:</strong> <span class="text-[#72383D]">{{ $selectedProduct->product_description }}</span></div>
                                            <div><strong class="text-[#401B1B]">Product Details:</strong> <span class="text-[#72383D]">{{ $selectedProduct->product_details }}</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Product Image</h3>
                                        @if ($selectedProduct->image)
                                            <img src="{{ Storage::url($selectedProduct->image) }}" alt="{{ $selectedProduct->product_name }}" class="w-full h-auto rounded-lg shadow-md">
                                        @else
                                            <img src="{{ asset('storage/uploads/default-image.jpg') }}" alt="Default Image" class="w-full h-auto rounded-lg shadow-md">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Description</h3>
                                <p class="text-[#72383D]">{{ $selectedProduct->product_description }}</p>
                            </div>

                            <div class="mb-4">
                                <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Detailed Specifications</h3>
                                <div class="text-[#72383D] whitespace-pre-line">{{ $selectedProduct->product_details }}</div>
                            </div>
                        </div>
                    @endif
                    <x-slot name="footer">
                        <div class="flex justify-end">
                            <x-button label="Close" wire:click="$set('productDetailsOpen', false)" class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300" />
                        </div>
                    </x-slot>
                </div>
            </div>
        </div>
    </div>
</div>