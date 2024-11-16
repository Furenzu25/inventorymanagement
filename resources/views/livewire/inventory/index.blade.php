<div>
    <x-header title="Inventory Management">
    </x-header>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4">
            <!-- Pending Orders Section -->
            <h2 class="text-lg font-semibold mb-4">Orders to Process</h2>
            <table class="w-full mb-8">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Order ID</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Serial Number</th>
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
                                    <div class="mb-1">
                                        {{ $item->product->product_name }} ({{ $item->quantity }})
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">
                                @foreach($preorder->inventoryItems as $item)
                                    <div class="mb-1">
                                        {{ $item->serial_number }}
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">{{ $preorder->status }}</td>
                            <td class="px-4 py-2">
                                @if($preorder->status === 'approved')
                                    <x-button wire:click="stockIn({{ $preorder->id }})" class="bg-blue-500">
                                        Stock In
                                    </x-button>
                                @elseif($preorder->status === 'in_stock')
                                    <x-button wire:click="processLoan({{ $preorder->id }})" class="bg-green-500">
                                        Process Loan
                                    </x-button>
                                @elseif($preorder->status === 'loaned')
                                    <x-button 
                                        wire:click="markAsRepossessed({{ $preorder->id }})"
                                        onclick="return confirm('Are you sure you want to mark this item as repossessed?')"
                                        class="bg-red-500 hover:bg-red-600 text-white">
                                        Mark as Repossessed
                                    </x-button>
                                @elseif($preorder->status === 'repossessed')
                                    <x-button 
                                        wire:click="reassignItem({{ $preorder->inventoryItems->first()->id }})"
                                        class="bg-green-500 hover:bg-green-600 text-white">
                                        Reassign Item
                                    </x-button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Repossessed Items Section -->
            <h2 class="text-lg font-semibold mb-4 mt-8">Repossessed Items</h2>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Order ID</th>
                        <th class="px-4 py-2 text-left">Previous Customer</th>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Serial Number</th>
                        <th class="px-4 py-2 text-left">Repossession Date</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repossessedItems as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">#{{ $item->preorder->id }}</td>
                            <td class="px-4 py-2">{{ $item->preorder->customer->name }}</td>
                            <td class="px-4 py-2">
                                @foreach($item->preorder->preorderItems as $preorderItem)
                                    <div class="mb-1">
                                        {{ $preorderItem->product->product_name }} ({{ $preorderItem->quantity }})
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">
                                @foreach($item->preorder->inventoryItems as $item)
                                    <div class="mb-1">
                                        {{ $item->serial_number }}
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">{{ $item->repossession_date }}</td>
                            <td class="px-4 py-2">
                                <x-button wire:click="restore({{ $item->id }})" class="bg-blue-500">
                                    Restore
                                </x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Available for Reassignment Section -->
            <h2 class="text-lg font-semibold mb-4 mt-8">Available for Reassignment</h2>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Serial Number</th>
                        <th class="px-4 py-2 text-left">Previous Customer</th>
                        <th class="px-4 py-2 text-left">Cancellation Date</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reassignableItems as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $item->product->product_name }}</td>
                            <td class="px-4 py-2">{{ $item->serial_number }}</td>
                            <td class="px-4 py-2">{{ $item->preorder->customer->name }}</td>
                            <td class="px-4 py-2">{{ $item->cancellation_date->format('M d, Y') }}</td>
                            <td class="px-4 py-2">
                                <x-button wire:click="assignToNewCustomer({{ $item->id }})" class="bg-green-500">
                                    Assign to Customer
                                </x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>