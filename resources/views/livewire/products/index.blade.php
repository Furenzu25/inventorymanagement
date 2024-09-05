<div>
    <!-- HEADER -->
    <x-header title="Products">
        <x-slot:actions>
            <x-button label="Create Product" wire:click="create" />
            <x-input placeholder="Search..." wire:model.debounce="search" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE -->
    <x-card>
        <x-table>
            <x-slot:headers>
                <x-table.header>Product Name</x-table.header>
                <x-table.header>Product Model</x-table.header>
                <x-table.header>Product Brand</x-table.header>
                <x-table.header>Product Category</x-table.header>
                <x-table.header>Product Description</x-table.header>
                <x-table.header>Storage Capacity</x-table.header>
                <x-table.header>Price</x-table.header>
            </x-slot:headers>
            <x-slot:rows>
                @foreach ($products as $product)
                    <x-table.row>
                        <x-table.cell>{{ $product->product_name }}</x-table.cell>
                        <x-table.cell>{{ $product->product_model }}</x-table.cell>
                        <x-table.cell>{{ $product->product_brand }}</x-table.cell>
                        <x-table.cell>{{ $product->product_category }}</x-table.cell>
                        <x-table.cell>{{ $product->product_description }}</x-table.cell>
                        <x-table.cell>{{ $product->storage_capacity }}</x-table.cell>
                        <x.table.cell>{{ $product->price }}</x.table.cell>
                        <x-table.cell>
                            <x-button label="Edit" wire:click="edit({{ $product->id }})" />
                            <x-button label="Delete" wire:click="delete({{ $product->id }})" />
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot:rows>
        </x-table>
    </x-card>

    <!-- Modal for creating/editing customers -->
    <x-modal wire:model.defer="modalOpen">
        <x-slot:title>
            {{ $product->id ? 'Edit Product' : 'Create Product' }}
        </x-slot:title>
        <form wire:submit.prevent="store">
            <x-input label="Product Name" wire:model.defer="product.product_name" />
            <x-input label="Product Model"  wire:model.defer="product.product_model" />
            <x-input label="Product Brand" wire:model.defer="product.product_brand" />
            <x-input label="Product Category" wire:model.defer="product.product_category" />
            <x-input label="Product Description" wire:model.defer="product.product_description" />
            <x-input label="Storage Capacity" wire:model.defer="product.storage_capacity" />
            <x-button type="Price" type="number" wire:model.defer="product.price" />
            <x-button type="submit" label="Save" />
        </form>
    </x-modal>
</div>
