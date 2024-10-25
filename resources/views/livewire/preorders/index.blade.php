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
            @scope('cell_status', $preorder)
                {{ $preorder->status }}
            @endscope
            @scope('actions', $preorder)
                <div class="flex justify-start gap-2 w-40">
                    @if($preorder->status === 'Pending')
                        <x-button wire:click="approvePreorder({{ $preorder->id }})" label="Approve" class="btn-success btn-sm" />
                    @endif
                    <x-button icon="o-pencil" wire:click="edit({{ $preorder->id }})" label="Edit" class="btn-primary btn-sm" />
                    <x-button icon="o-trash" wire:click="delete({{ $preorder->id }})" wire:confirm="Are you sure?" spinner class="btn-ghost btn-sm text-red-500" />
                </div>
            @endscope
        </x-table>
        {{ $preorders->links() }}
    </x-card>

    @teleport('body')
        <x-modal class="backdrop-blur-md border border-red-500/30" wire:model.defer="modalOpen" title="{{ $preorderId ? 'Edit Pre-order' : 'Create Pre-order' }}">
            <div class="p-4 bg-base-100 rounded-b-xl w-full">
                <form wire:submit.prevent="store" class="space-y-4 w-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-select 
                            label="Customer" 
                            wire:model="preorder.customer_id"
                            :options="$customers->map(function($customer) {
                                return ['id' => $customer->id, 'name' => $customer->name];
                            })"
                            placeholder="Select a customer"
                            class="w-full"
                        />
                        <x-input label="Loan Duration (months)" wire:model.defer="preorder.loan_duration" type="number" class="w-full" />
                        <x-input 
                            label="Bought Location" 
                            wire:model.defer="preorder.bought_location" 
                            placeholder="Enter bought location"
                            class="w-full"
                        />
                        <x-select 
                            label="Status" 
                            wire:model.defer="preorder.status"
                            placeholder="Select status"
                            :options="[
                                ['name' => 'Ongoing', 'id' => 'Ongoing'],
                                ['name' => 'Ready', 'id' => 'Ready']
                            ]"
                            class="w-full"
                        />  
                        <x-select 
                            label="Payment Method" 
                            wire:model.defer="preorder.payment_method"
                            placeholder="Select method"
                            :options="[
                                ['name' => 'Cash', 'id' => 'Cash'],
                                ['name' => 'Card', 'id' => 'Card']
                            ]"
                            class="w-full"
                        />  
                        <x-input label="Order Date" wire:model.defer="preorder.order_date" type="date" class="w-full" />
                        <x-input label="Total Amount" wire:model.defer="preorder.total_amount" type="number" step="0.01" class="w-full" readonly />
                        <x-input label="Monthly Payment" wire:model.defer="preorder.monthly_payment" type="number" step="0.01" class="w-full" readonly />
                        <x-input label="Interest Rate (%)" wire:model.defer="preorder.interest_rate" type="number" step="0.01" class="w-full" readonly />
                    </div>

                    <div class="mt-6 w-full">
                        <h3 class="text-xl font-semibold mb-4">Order Items</h3>
                        @foreach($preorderItems as $index => $item)
                            <div class="flex flex-wrap items-center space-x-2 mb-4 pb-4 border-b border-gray-200 w-full">
                                <div class="w-full md:w-1/3 mb-2 md:mb-0">
                                    <x-select 
                                        label="Product"
                                        wire:model.live="preorderItems.{{ $index }}.product_id"
                                        :options="$products->map(function($product) {
                                            return ['id' => $product->id, 'name' => $product->product_name];
                                        })"
                                        placeholder="Select a product"
                                        class="w-full"
                                    />
                                </div>
                                <div class="w-full md:w-1/4 mb-2 md:mb-0">
                                    <x-input 
                                        label="Quantity"
                                        wire:model.defer="preorderItems.{{ $index }}.quantity" 
                                        type="number" 
                                        min="1" 
                                        class="w-full" 
                                        placeholder="Qty" 
                                    />
                                </div>
                                <div class="w-full md:w-1/4 mb-2 md:mb-0">
                                    <x-input 
                                        label="Price"
                                        wire:model.defer="preorderItems.{{ $index }}.price" 
                                        type="number" 
                                        step="0.01" 
                                        class="w-full" 
                                        placeholder="Price" 
                                        readonly 
                                    />
                                </div>
                                <div class="w-full md:w-auto flex items-end">
                                    @if($index > 0)
                                        <x-button 
                                            wire:click="removeItem({{ $index }})" 
                                            icon="o-trash" 
                                            class="btn-ghost btn-sm text-red-500" 
                                            label="Remove"
                                        />
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <x-button 
                            wire:click="addItem" 
                            icon="o-plus" 
                            label="Add Item" 
                            class="btn-outline btn-sm mt-4" 
                        />
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-button type="submit" label="Save" class="btn-outline text-red-500" />
                    </div>
                </form>
            </div>
        </x-modal>
    @endteleport
</div>
