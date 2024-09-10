<div>
    @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif

    <x-header title="Pre-orders">
        <x-slot:actions>
            <x-button label="Create Pre-order" wire:click="create" class="btn-outline text-red-500" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table :headers="$this->headers()" :rows="$preorders" :sort-by="$sortBy">
            @scope('cell_customer.name', $preorder)
                {{ $preorder->customer->name }}
            @endscope
            @scope('cell_product.product_name', $preorder)
                {{ $preorder->product->product_name }}
            @endscope
            @scope('actions', $preorder)
                <div class="flex justify-start gap-2 w-40">
                    <x-button icon="o-pencil" wire:click="edit({{ $preorder->id }})" label="Edit" class="btn-primary btn-sm" />
                    <x-button icon="o-trash" wire:click="delete({{ $preorder->id }})" wire:confirm="Are you sure?" spinner class="btn-ghost btn-sm text-red-500" />
                </div>
            @endscope
        </x-table>
        {{ $preorders->links() }}
    </x-card>
@teleport('body')
    <x-modal wire:model.defer="modalOpen" title="{{ $preorderId ? 'Edit Pre-order' : 'Create Pre-order' }}">
    <div class="p-1 bg-base-100 rounded-b-xl">
        <form wire:submit.prevent="store">
                <x-select 
                    label="Customer" 
                    wire:model="preorder.customer_id"
                    :options="$customers->map(function($customer) {
                        return ['id' => $customer->id, 'name' => $customer->name];
                    })"
                    placeholder="Select a customer"
                />
                <x-select 
                    label="Product" 
                    wire:model.live="preorder.product_id"
                    :options="$products->map(function($product) {
                        return ['id' => $product->id, 'name' => $product->product_name];
                    })"
                    placeholder="Select a product"
                />
                <x-input label="Loan Duration (months)" wire:model.defer="preorder.loan_duration" type="number" class="mb-1"    />
                <x-input label="Quantity" wire:model.defer="preorder.quantity" type="number" class="mb-1"/>
                <x-input 
                    label="Price" 
                    wire:model="preorder.price" 
                    type="number" 
                    step="0.01" 
                    readonly 
                />
                <x-input label="Bought Location" wire:model.defer="preorder.bought_location" class="mb-1"/>
                <x-select 
                label="Status" 
                wire:model.defer="preorder.status"
                placeholder="Select status"
                :options="[
                    ['name' => 'Ongoing', 'id' => 'Ongoing'],
                    ['name' => 'Ready', 'id' => 'Ready']
                ]"
                class="mb-1"/>  
                <x-select 
                label="Payment Method" 
                wire:model.defer="preorder.payment_method"
                placeholder="Select method"
                :options="[
                    ['name' => 'Cash', 'id' => 'Cash'],
                    ['name' => 'Card', 'id' => 'Card']
                ]"
                class="mb-1"/>  
            
                <x-input label="Order Date" wire:model.defer="preorder.order_date" type="date" class="mb-1"/>
                <x-button type="submit" label="Save" class="btn-outline text-red-500 mt-4"/>
            </form>
        </div>
    </x-modal>
@endteleport
</div>
