<div>
    <x-header title="Inventory Management">
        <x-slot:actions>
            <x-button label="Add to Inventory" wire:click="openAddModal" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" />
        </x-slot:actions>
    </x-header>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4">
            <!-- Pending Preorders Section -->
            <h2 class="text-lg font-semibold mb-4">Pending Orders to Process</h2>
            <table class="w-full mb-8">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Order ID</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingPreorders as $preorder)
                        <tr class="border-b">
                            <td class="px-4 py-2">#{{ $preorder->id }}</td>
                            <td class="px-4 py-2">{{ $preorder->customer->name }}</td>
                            <td class="px-4 py-2">
                                @foreach($preorder->preorderItems as $item)
                                    {{ $item->product->product_name }}<br>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">{{ $preorder->status }}</td>
                            <td class="px-4 py-2">
                                <x-button wire:click="processOrder({{ $preorder->id }})" class="bg-green-500 hover:bg-green-600 text-white">
                                    Process Order
                                </x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Current Inventory Section -->
            <h2 class="text-lg font-semibold mb-4">Current Inventory</h2>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Serial Number</th>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Assigned To</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventoryItems as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $item->serial_number }}</td>
                            <td class="px-4 py-2">{{ $item->product->product_name }}</td>
                            <td class="px-4 py-2">{{ $item->status }}</td>
                            <td class="px-4 py-2">
                                {{ $item->preorder ? $item->preorder->customer->name : 'N/A' }}
                            </td>
                            <td class="px-4 py-2">
                                @if($item->status === 'in_stock')
                                    <x-button wire:click="assignToOrder({{ $item->id }})" class="bg-blue-500 hover:bg-blue-600 text-white">
                                        Assign to Order
                                    </x-button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Available Products Section -->
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-4">Available Products</h2>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">Product</th>
                                <th class="px-4 py-2 text-left">Serial Number</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($availableItems as $item)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $item->product->product_name }}</td>
                                    <td class="px-4 py-2">{{ $item->serial_number }}</td>
                                    <td class="px-4 py-2">
                                        @if($pendingPreorders->isNotEmpty())
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <x-button>Assign to Pre-order</x-button>
                                                </x-slot>
                                                
                                                @foreach($pendingPreorders as $preorder)
                                                    <x-dropdown-item 
                                                        wire:click="assignAvailableProduct({{ $item->id }}, {{ $preorder->id }})"
                                                    >
                                                        Order #{{ $preorder->id }} - {{ $preorder->customer->name }}
                                                    </x-dropdown-item>
                                                @endforeach
                                            </x-dropdown>
                                        @else
                                            <span class="text-gray-500">No pending pre-orders</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Inventory Modal -->
    <x-modal wire:model="modalOpen">
        <x-slot name="title">
            Add to Inventory
        </x-slot>

        <div class="p-4">
            @if($processingPreorder)
                <p class="mb-4">Processing order #{{ $processingPreorder->id }}</p>
                <p class="mb-4">Customer: {{ $processingPreorder->customer->name }}</p>
                <p class="mb-4">Product: {{ $processingPreorder->preorderItems->first()->product->product_name }}</p>
                
                <x-button 
                    wire:click="addToInventory" 
                    class="bg-blue-500 hover:bg-blue-600 text-white w-full"
                >
                    Add to Inventory
                </x-button>
            @endif
        </div>
    </x-modal>

    <!-- Assign to Order Modal -->
    <x-modal wire:model="assignModalOpen">
        <x-slot name="title">
            Assign Product to Order
        </x-slot>

        <div class="p-4">
            @if($selectedInventoryItem && $availablePreorders->isNotEmpty())
                <p class="mb-4">Select a pre-order to assign this product to:</p>
                
                @foreach($availablePreorders as $preorder)
                    <div class="mb-4 p-4 border rounded">
                        <p>Order #{{ $preorder->id }}</p>
                        <p>Customer: {{ $preorder->customer->name }}</p>
                        <x-button 
                            wire:click="confirmAssignment({{ $preorder->id }})"
                            class="bg-blue-500 hover:bg-blue-600 text-white mt-2"
                        >
                            Assign to this order
                        </x-button>
                    </div>
                @endforeach
            @else
                <p>No pending pre-orders available for this product.</p>
            @endif
        </div>
    </x-modal>
</div>