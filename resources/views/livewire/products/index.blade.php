<div>
    <!-- HEADER -->
    @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <x-header title="Products">
        <x-slot:actions>
            <x-button label="Create Product" wire:click="create" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out" />
        </x-slot:actions>
    </x-header>

    <!-- PRODUCTS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($products as $product)
            <div class="bg-gray shadow-md rounded-lg overflow-hidden flex flex-col">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-contain">
                    @else
                        <img src="{{ asset('storage/uploads/default-image.jpg') }}" alt="Default Image" class="w-full h-full object-contain">
                    @endif
                </div>
                <div class="p-4 flex-grow">
                    <h2 class="text-lg font-semibold">{{ $product->product_name }}</h2>
                    <p class="text-xl font-bold mt-2">₱{{ number_format($product->price, 2) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <x-button 
                            label="View Details" 
                            wire:click="showProductDetails({{ $product->id }})" 
                            class="bg-blue-600 hover:bg-blue-700 text-white"
                        />
                        <x-button 
                            icon="o-pencil" 
                            wire:click="edit({{ $product->id }})" 
                            class="btn-icon btn-xs bg-gray-200 hover:bg-gray-300 text-gray-600"
                        />
                        <x-button 
                            icon="o-trash" 
                            wire:click="delete({{ $product->id }})" 
                            wire:confirm="Are you sure?" 
                            spinner 
                            class="btn-icon btn-xs bg-red-200 hover:bg-red-300 text-red-600"
                        />
                    </div>
                </div>
            </div>
        @endforeach
    </div>  

    <!-- Pagination -->
    {{ $products->links() }}

    <!-- Modal for product details -->
    <x-modal wire:model="modalOpen">
        <x-card title="{{ $productId ? 'Edit Product' : 'Create Product' }}">
            <form wire:submit.prevent="store">
                <div class="space-y-4">
                    <x-input label="Product Name" wire:model="product.product_name" />
                    <x-input label="Model" wire:model="product.product_model" />
                    <x-input label="Brand" wire:model="product.product_brand" />
                    <x-input label="Category" wire:model="product.product_category" />
                    <x-input label="Description" wire:model="product.product_description" />
                    
                    <!-- Dropdown for Storage Capacity -->
                    <div>
                        <label for="storage_capacity" class="block text-sm font-medium text-gray-700">Storage Capacity</label>
                        <select id="storage_capacity" wire:model="product.storage_capacity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Storage Capacity</option>
                            <option value="64GB">64GB</option>
                            <option value="128GB">128GB</option>
                            <option value="256GB">256GB</option>
                            <option value="512GB">512GB</option>
                            <option value="1TB">1TB</option>
                        </select>
                        @error('product.storage_capacity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <x-input label="Price" type="number" step="0.01" wire:model="product.price" />
                    <x-input label="Product Image" type="file" wire:model="image" />
                </div>
                <div class="mt-4 flex justify-end">
                    <x-button type="button" wire:click="closeModal" class="mr-2">Cancel</x-button>
                    <x-button type="submit">Save</x-button>
                </div>
            </form>
        </x-card>
    </x-modal>

    <!-- Modal for product details -->
    <x-modal wire:model="productDetailsOpen">
        <x-card title="Product Details">
            @if($selectedProduct)
                <div class="space-y-4">
                    <div><strong>Name:</strong> {{ $selectedProduct->product_name }}</div>
                    <div><strong>Price:</strong> ₱{{ number_format($selectedProduct->price, 2) }}</div>
                    <div><strong>Description:</strong> {{ $selectedProduct->product_description }}</div>
                    <div><strong>Storage Capacity:</strong> {{ $selectedProduct->storage_capacity }}</div>
                    <div><strong>Category:</strong> {{ $selectedProduct->product_category }}</div>
                    <div>
                        <strong>Image:</strong>
                        @if ($selectedProduct->image)
                            <img src="{{ Storage::url($selectedProduct->image) }}" alt="{{ $selectedProduct->product_name }}" class="mt-2 max-w-full h-auto">
                        @else
                            <img src="{{ asset('storage/uploads/default-image.jpg') }}" alt="Default Image" class="mt-2 max-w-full h-auto">
                        @endif
                    </div>
                </div>
            @endif
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button label="Close" wire:click="$set('productDetailsOpen', false)" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
