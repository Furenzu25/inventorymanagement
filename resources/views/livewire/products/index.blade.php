<div>
    <!-- HEADER -->  @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif
    <x-header title="Products">
        <x-slot:actions>
            <x-button label="Create Product" wire:click="create" class="btn-outline text-red-500"/>
           
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$products" :sort-by="$sortBy">
            @scope('cell_product_name', $product)
                {{ $product->product_name }}
            @endscope
            @scope('cell_product_model', $product)
                {{ $product->product_model }}
            @endscope
            <!-- ... other columns ... -->
            @scope('actions', $product)
                <div class="flex justify-start gap-2 w-40">
                    <x-button icon="o-pencil" wire:click="edit({{ $product->id }})" label="Edit" class="btn-primary btn-sm" />
                    <x-button icon="o-trash" wire:click="delete({{ $product->id }})" wire:confirm="Are you sure?" spinner class="btn-ghost btn-sm text-red-500" />
                </div>
            @endscope
        </x-table>
        {{ $products->links() }}
    </x-card>

    <!-- Modal for creating/editing products -->

    @teleport('body')
    <x-modal wire:model="modalOpen" max-width="md" class="backdrop-blur-md border border-red-500/30" title="{{ isset($product['id']) ? 'Edit Product' : 'Create Product' }}">

            <form wire:submit.prevent="store">
                <div class="space-y-4">
                    <x-input label="Product Name" wire:model.defer="product.product_name" class="mb-0.5" />
                    <x-input label="Model" wire:model.defer="product.product_model" class="mb-0.5" />
                    <x-input label="Brand" wire:model.defer="product.product_brand" class="mb-0.5" />
                    <x-input label="Category" wire:model.defer="product.product_category" class="mb-0.5" />
                    <x-input label="Description" wire:model.defer="product.product_description" class="mb-0.5" />
                    <x-select 
                        label="Storage Capacity" 
                        wire:model.defer="product.storage_capacity"
                        placeholder="Select storage capacity"
                        :options="[ 
                            ['name' => '128GB', 'id' => '128GB'],
                            ['name' => '256GB', 'id' => '256GB'],
                            ['name' => '512GB', 'id' => '512GB']
                        ]"
                    />
                    <x-input label="Price" type="number" wire:model.defer="product.price" />
                </div>
                
                <div class="flex justify-end gap-x-4 mt-4">
                    <x-button label="Cancel" wire:click="closeModal" class="btn-outline text-blue-500" />
                    <x-button label="Save" type="submit" class="btn-outline text-red-500" wire:loading.attr="disabled" />
                </div>
            </form>
     
    </x-modal>
    @endteleport
    
</div>


