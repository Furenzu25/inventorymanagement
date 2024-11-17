<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <x-header title="Inventory Management" class="text-[#401B1B] text-3xl font-bold mb-6" />

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <!-- Pending Orders Section -->
            <h2 class="text-xl font-semibold mb-4 text-[#401B1B]">Orders to Process</h2>
            <div class="overflow-x-auto">
                <table class="w-full mb-8">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                            <th class="px-4 py-3 text-left">Order ID</th>
                            <th class="px-4 py-3 text-left">Customer</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Serial Number</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingPreorders as $preorder)
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">#{{ $preorder->id }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $preorder->customer->name }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    @foreach($preorder->preorderItems as $item)
                                        <div class="mb-1">
                                            {{ $item->product->product_name }} ({{ $item->quantity }})
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    @foreach($preorder->inventoryItems as $item)
                                        <div class="mb-1">
                                            {{ $item->serial_number }}
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $preorder->status }}</td>
                                <td class="px-4 py-3">
                                    @if($preorder->status === 'approved')
                                        <x-button wire:click="stockIn({{ $preorder->id }})" class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300">
                                            Stock In
                                        </x-button>
                                    @elseif($preorder->status === 'in_stock')
                                        <x-button wire:click="processLoan({{ $preorder->id }})" class="bg-[#AB644B] hover:bg-[#72383D] text-white transition duration-300">
                                            Process Loan
                                        </x-button>
                                    @elseif($preorder->status === 'loaned')
                                        <x-button 
                                            wire:click="markAsRepossessed({{ $preorder->id }})"
                                            onclick="return confirm('Are you sure you want to mark this item as repossessed?')"
                                            class="bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300">
                                            Mark as Repossessed
                                        </x-button>
                                    @elseif($preorder->status === 'repossessed')
                                        <x-button 
                                            wire:click="reassignItem({{ $preorder->inventoryItems->first()->id }})"
                                            class="bg-[#D2DCE6] hover:bg-[#9CABB4] text-[#401B1B] transition duration-300">
                                            Reassign Item
                                        </x-button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Repossessed Items Section -->
            <h2 class="text-xl font-semibold mb-4 mt-8 text-[#401B1B]">Repossessed Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white">
                            <th class="px-4 py-3 text-left">Order ID</th>
                            <th class="px-4 py-3 text-left">Previous Customer</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Serial Number</th>
                            <th class="px-4 py-3 text-left">Repossession Date</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repossessedItems as $item)
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">#{{ $item->preorder->id }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->preorder->customer->name }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    @foreach($item->preorder->preorderItems as $preorderItem)
                                        <div class="mb-1">
                                            {{ $preorderItem->product->product_name }} ({{ $preorderItem->quantity }})
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    @foreach($item->preorder->inventoryItems as $inventoryItem)
                                        <div class="mb-1">
                                            {{ $inventoryItem->serial_number }}
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->repossession_date }}</td>
                                <td class="px-4 py-3">
                                    <x-button wire:click="restore({{ $item->id }})" class="bg-[#AB644B] hover:bg-[#72383D] text-white transition duration-300">
                                        Restore
                                    </x-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Available for Reassignment Section -->
            <h2 class="text-xl font-semibold mb-4 mt-8 text-[#401B1B]">Available for Reassignment</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#AB644B] to-[#9CABB4] text-white">
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Serial Number</th>
                            <th class="px-4 py-3 text-left">Previous Customer</th>
                            <th class="px-4 py-3 text-left">Cancellation Date</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reassignableItems as $item)
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->product->product_name }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->serial_number }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->preorder->customer->name }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->cancellation_date->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    <x-button wire:click="assignToNewCustomer({{ $item->id }})" class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300">
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
</div>