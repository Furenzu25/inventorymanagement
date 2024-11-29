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
                            <th class="px-4 py-3 text-left">Pickup Details</th>
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
                                    @if($preorder->inventoryItems->isNotEmpty())
                                        <x-button 
                                            wire:click="showPickupDetails({{ $preorder->id }})" 
                                            class="bg-[#AB644B] hover:bg-[#72383D] text-white text-xs py-1 px-2 rounded transition duration-300 shadow-sm"
                                        >
                                            View Details
                                        </x-button>
                                    @else
                                        <span class="text-gray-500">No pickup details</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($preorder->status === 'approved')
                                        <x-button 
                                            wire:click="openStockInModal({{ $preorder->id }})" 
                                            class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300"
                                        >
                                            Stock In
                                        </x-button>
                                    @elseif($preorder->status === 'in_stock' || $preorder->status === 'picked_up')
                                        @foreach($preorder->inventoryItems as $item)
                                            @if(!$item->picked_up_at)
                                                <x-button 
                                                    wire:click="openPickupModal({{ $item->id }})" 
                                                    class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300 mb-2"
                                                >
                                                    Record Pickup
                                                </x-button>
                                            @endif
                                        @endforeach
                                        
                                        @if($preorder->inventoryItems->where('picked_up_at', '!=', null)->count() > 0)
                                            <x-button 
                                                wire:click="processLoan({{ $preorder->id }})" 
                                                class="bg-[#AB644B] hover:bg-[#72383D] text-white transition duration-300"
                                            >
                                                Process Loan
                                            </x-button>
                                        @endif
                                    @elseif($preorder->status === 'loaned')
                                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                                            Loan Active
                                        </span>
                                    @elseif($preorder->status === 'arrived')
                                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                            Ready for Pickup
                                        </span>
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

            <!-- Stocked Out Items Section -->
            <h2 class="text-xl font-semibold mb-4 mt-8 text-[#401B1B]">Stocked Out Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white">
                            <th class="px-4 py-3 text-left">Order ID</th>
                            <th class="px-4 py-3 text-left">Customer</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Serial Number</th>
                            <th class="px-4 py-3 text-left">Stocked Out Date</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockedOutItems as $item)
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">#{{ $item->preorder->id }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->preorder->customer->name }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->product->product_name }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->serial_number }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $item->updated_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                                        Stocked Out
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pickup Modal -->
    <x-modal wire:model="showPickupModal">
        <div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] p-6 rounded-lg border-2 border-[#72383D]">
            <h2 class="text-[#401B1B] text-2xl font-bold mb-6">Stock-in Details</h2>
            
            <div class="space-y-4">
                <!-- Debug Info -->
                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Bought Location -->
                <div>
                    <label class="block text-[#401B1B] font-semibold mb-2">
                        Bought Location
                    </label>
                    <x-input
                        wire:model.defer="boughtLocation"
                        class="w-full bg-[#1F2937] text-white border-[#72383D] focus:border-[#401B1B] focus:ring focus:ring-[#401B1B]/20"
                        placeholder="Enter where the item was bought..."
                    />
                    @error('boughtLocation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Bought Date -->
                <div>
                    <label class="block text-[#401B1B] font-semibold mb-2">
                        Bought Date
                    </label>
                    <x-input
                        type="datetime-local"
                        wire:model.defer="boughtDate"
                        class="w-full bg-[#1F2937] text-white border-[#72383D] focus:border-[#401B1B] focus:ring focus:ring-[#401B1B]/20"
                    />
                    @error('boughtDate')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pickup Notes -->
                <div>
                    <label class="block text-[#401B1B] font-semibold mb-2">
                        Pickup Notes
                    </label>
                    <textarea
                        wire:model.defer="pickupNotes"
                        class="w-full rounded-md bg-[#1F2937] text-white border-[#72383D] focus:border-[#401B1B] focus:ring focus:ring-[#401B1B]/20"
                        rows="3"
                        placeholder="Enter any additional notes about the pickup..."
                    ></textarea>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <x-button 
                        wire:click="$set('showPickupModal', false)" 
                        class="bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300"
                    >
                        Cancel
                    </x-button>
                    <x-button 
                        wire:click="stockIn({{ $selectedPreorder?->id }})"
                        class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300"
                    >
                        <span wire:loading.remove wire:target="stockIn">Confirm Stock-in</span>
                        <span wire:loading wire:target="stockIn">Processing...</span>
                    </x-button>
                </div>
            </div>
        </div>
    </x-modal>

    <!-- Record Pickup Modal -->
    <div x-data="{ show: @entangle('showRecordPickupModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-md transition-opacity"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-[#401B1B] mb-6">Record Pickup Details</h2>
                    
                    <div class="space-y-4">
                        @if ($errors->any())
                            <div class="bg-[#AB644B]/10 text-[#AB644B] p-4 rounded-lg mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Pickup Notes -->
                        <div>
                            <label class="block text-[#401B1B] font-semibold mb-2">Pickup Notes</label>
                            <textarea
                                wire:model.defer="pickupNotes"
                                class="w-full rounded-lg border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                rows="3"
                                placeholder="Enter any additional notes about the pickup..."
                            ></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3 mt-6">
                            <button 
                                wire:click="$set('showRecordPickupModal', false)"
                                class="px-4 py-2 bg-[#9CABB4] hover:bg-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                Cancel
                            </button>
                            <button 
                                wire:click="recordPickup({{ $selectedInventoryItem?->id }})"
                                class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                <span wire:loading.remove wire:target="recordPickup">Confirm Pickup</span>
                                <span wire:loading wire:target="recordPickup">Processing...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button 
                        type="button"
                        wire:click="$set('showRecordPickupModal', false)"
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pickup Details Modal -->
    <x-modal wire:model="showPickupDetailsModal">
        <div class="p-6 bg-white">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Pickup Details</h2>
            @if($selectedPreorder)
                @foreach($selectedPreorder->inventoryItems as $item)
                    <div class="space-y-3 mb-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="font-semibold text-gray-700">Product: {{ $item->product->product_name }}</p>
                            <p class="font-semibold text-gray-700">Serial Number: {{ $item->serial_number }}</p>
                            <p class="font-semibold text-gray-700">Verification: {{ $item->pickup_verification }}</p>
                            <p class="text-gray-600">Bought at: {{ $item->bought_location }}</p>
                            <p class="text-gray-600">Bought on: {{ $item->bought_date?->format('M d, Y H:i') }}</p>
                            <p class="text-gray-600">Picked up: {{ $item->picked_up_at?->format('M d, Y H:i') ?? 'Not picked up' }}</p>
                            @if($item->picked_up_by)
                                <p class="text-gray-600">By: {{ optional($item->pickedUpBy)->name }}</p>
                            @endif
                            @if($item->pickup_notes)
                                <p class="text-gray-500 text-sm">Notes: {{ $item->pickup_notes }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </x-modal>
</div>