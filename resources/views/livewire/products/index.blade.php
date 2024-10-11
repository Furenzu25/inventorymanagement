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
            <x-button label="Create Product" wire:click="create" class="btn-outline text-red-500"/>
        </x-slot:actions>
    </x-header>

    <!-- PRODUCTS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($products as $product)
            <div class="bg-gray shadow-md rounded-lg overflow-hidden flex flex-col">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if (!empty($product->image))
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-contain">
                    @else
                        <!-- Default image when no product image is available -->
                        <img src="{{ asset('storage/uploads/default-image.jpg') }}" alt="Default Image" class="w-full h-full object-contain">
                    @endif
                </div>
                <div class="p-4 flex-grow">
                    <h2 class="text-lg font-semibold">{{ $product->product_name }}</h2>
                    <p class="text-xl font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <x-button icon="o-pencil" wire:click="edit({{ $product->id }})" label="Edit" class="btn-primary btn-sm" />
                        <x-button icon="o-trash" wire:click="delete({{ $product->id }})" wire:confirm="Are you sure?" spinner class="btn-ghost btn-sm text-red-500" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>  

    <!-- Pagination -->
    {{ $products->links() }}

    <!-- Modal for creating/editing products -->
    @teleport('body')
        <x-modal wire:model="modalOpen" max-width="md" class="backdrop-blur-md border border-red-500/30" title="{{ isset($product['id']) ? 'Edit Product' : 'Create Product' }}">
            <form wire:submit.prevent="store">
                <div class="space-y-4">
                    <x-input label="Product Name" wire:model.defer="product.product_name" class="mb-0.5" />
                    <x-input label="Model" wire:model.defer="product.product_model" class="mb-0.5" />
                    <x-input label="Brand" wire:model.defer="product.product_brand" class="mb-0.5" />
                    <x-input label="Category" wire:model.defer="product.product_category" class="mb-0.5" />
                    <x-textarea label="Description" wire:model.defer="product.product_description" class="mb-0.5" />
                    <x-select 
                        label="Storage Capacity" 
                        wire:model.defer="product.storage_capacity"
                        placeholder="Select storage capacity"
                        :options="[ 
                            ['name' => '16GB', 'id' => '16GB'],
                            ['name' => '32GB', 'id' => '32GB'],
                            ['name' => '64GB', 'id' => '64GB'],
                            ['name' => '128GB', 'id' => '128GB'],
                            ['name' => '256GB', 'id' => '256GB'],
                            ['name' => '512GB', 'id' => '512GB']
                        ]"
                    />
                    <x-input label="Price" type="number" wire:model.defer="product.price" />

                    <!-- Image Upload -->
                    <div>
                        <x-file wire:model="image" label="Product Image" hint="Max 5MB" accept="image/*" class="mb-0.5" />
                        @if($imageUploaded)
                            <p class="text-sm text-green-500 mt-1">Image Uploaded</p>
                        @endif
                        @if($existingImage)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-1">Current Image:</p>
                                <img src="{{ asset('storage/' . $existingImage) }}" alt="Current Product Image" class="w-32 h-32 object-cover rounded">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end gap-x-4 mt-4">
                    <x-button label="Cancel" wire:click="closeModal" class="btn-outline text-blue-500" />
                    <x-button label="Save" type="submit" class="btn-outline text-red-500" wire:loading.attr="disabled" />
                </div>
            </form>
        </x-modal>
    @endteleport

</div>
