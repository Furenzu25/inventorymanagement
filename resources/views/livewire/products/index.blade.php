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
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-contain">
                    @else
                        <img src="{{ asset('storage/uploads/default-image.jpg') }}" alt="Default Image" class="w-full h-full object-contain">
                    @endif
                </div>
                <div class="p-4 flex-grow">
                    <h2 class="text-lg font-semibold">{{ $product->product_name }}</h2>
                    <p class="text-xl font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <x-button label="View Details" wire:click="showProductDetails({{ $product->id }})" class="btn-sm mt-2 bg-red-500 hover:bg-red-600 text-white" />
                        <x-button icon="o-pencil" wire:click="edit({{ $product->id }})" label="Edit" class="btn-primary btn-sm" />
                        <x-button icon="o-trash" wire:click="delete({{ $product->id }})" wire:confirm="Are you sure?" spinner class="btn-ghost btn-sm text-red-500" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>  

    <!-- Pagination -->
    {{ $products->links() }}

    <!-- Modal for product details -->
    <x-modal wire:model="modalOpen">
        <x-slot:title>
            {{ $product['product_name'] ?? '' }} Details
        </x-slot:title>
        <div class="space-y-2">
            @if($product)
                <p><strong>Model:</strong> {{ $product['product_model'] }}</p>
                <p><strong>Brand:</strong> {{ $product['product_brand'] }}</p>
                <p><strong>Category:</strong> {{ $product['product_category'] }}</p>
                <p><strong>Description:</strong> {{ $product['product_description'] }}</p>
                <p><strong>Storage Capacity:</strong> {{ $product['storage_capacity'] }}</p>
                <p><strong>Price:</strong> ${{ number_format($product['price'], 2) }}</p>
                @if($product['image'])
                    <div class="mt-4">
                        <strong>Product Image:</strong>
                        <img src="{{ Storage::url($product['image']) }}" alt="Product Image" class="mt-2 max-w-full h-auto">
                    </div>
                @endif
            @endif
        </div>
        <x-slot:footer>
            <x-button label="Close" wire:click="closeModal" />
        </x-slot:footer>
    </x-modal>
</div>
