<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    @if (session()->has('message'))
        <div class="alert alert-success mb-4 bg-[#72383D] text-white p-4 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <x-header title="Pre-orders" class="text-[#401B1B] text-3xl font-bold" />
        <x-input 
            icon="o-magnifying-glass" 
            placeholder="Search pre-orders..." 
            wire:model.live="search" 
            class="w-72 bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
        />
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Products</th>
                        <th class="px-4 py-3 text-left">Order Details</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($preorders as $preorder)
                        <tr class="border-b hover:bg-[#F2F2EB]/50 transition-colors duration-200">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-[#401B1B] to-[#72383D] rounded-full flex items-center justify-center">
                                        <span class="text-lg text-white font-bold">{{ strtoupper(substr($preorder->customer->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#401B1B]">{{ $preorder->customer->name }}</p>
                                        <p class="text-sm text-[#72383D]">{{ $preorder->customer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 max-w-md">
                                @foreach($preorder->preorderItems as $item)
                                    <div class="mb-2 p-2 bg-[#F2F2EB]/50 rounded">
                                        <p class="font-medium text-[#401B1B]">{{ $item->product->product_name }}</p>
                                        <div class="text-sm text-[#72383D] flex gap-2">
                                            <span>Qty: {{ $item->quantity }}</span>
                                            <span>•</span>
                                            <span>₱{{ number_format($item->price, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="space-y-1">
                                    <p><span class="text-[#72383D]">Duration:</span> {{ $preorder->loan_duration }}mo</p>
                                    <p><span class="text-[#72383D]">Monthly:</span> ₱{{ number_format($preorder->monthly_payment, 2) }}</p>
                                    <p><span class="text-[#72383D]">Total:</span> ₱{{ number_format($preorder->total_amount, 2) }}</p>
                                    <p><span class="text-[#72383D]">Location:</span> {{ $preorder->bought_location }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-sm rounded-full inline-flex items-center
                                    {{ $preorder->status === 'Ongoing' ? 'bg-[#AB644B]' : 
                                       ($preorder->status === 'disapproved' ? 'bg-red-500' : 'bg-[#72383D]') }} text-white">
                                    {{ $preorder->status }}
                                </span>
                                @if($preorder->status === 'disapproved')
                                    <p class="text-xs text-red-600 mt-1" title="{{ $preorder->disapproval_reason }}">
                                        {{ Str::limit($preorder->disapproval_reason, 30) }}
                                    </p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1">
                                    @if($preorder->status === 'Pending')
                                        <x-button wire:click="approvePreorder({{ $preorder->id }})" 
                                            class="bg-[#72383D] hover:bg-[#401B1B] text-white text-xs px-2 py-1">
                                            Approve
                                        </x-button>
                                        <x-button wire:click="openDisapprovalModal({{ $preorder->id }})" 
                                            class="bg-[#AB644B] hover:bg-[#72383D] text-white text-xs px-2 py-1">
                                            Disapprove
                                        </x-button>
                                    @endif
                                    <x-button icon="o-pencil" wire:click="edit({{ $preorder->id }})" 
                                        class="bg-[#9CABB4] hover:bg-[#72383D] text-white text-xs px-2 py-1" />
                                    <x-button icon="o-trash" wire:click="delete({{ $preorder->id }})" 
                                        wire:confirm="Are you sure you want to delete this pre-order?" 
                                        class="bg-[#AB644B] hover:bg-[#72383D] text-white text-xs px-2 py-1" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $preorders->links() }}
    </div>

    <!-- Disapproval Modal -->
    <x-modal wire:model="showDisapprovalModal">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-[#401B1B] mb-6">Disapprove Pre-order</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-[#401B1B] font-medium mb-2">Reason for Disapproval</label>
                    <textarea
                        wire:model="disapprovalReason"
                        class="w-full rounded-lg border-[#AB644B]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 shadow-inner resize-none"
                        rows="4"
                        placeholder="Please provide a detailed reason for disapproval..."
                    ></textarea>
                    @error('disapprovalReason')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <x-button wire:click="$set('showDisapprovalModal', false)" 
                        class="bg-[#9CABB4] hover:bg-[#72383D]">
                        Cancel
                    </x-button>
                    <x-button wire:click="disapprovePreorder" 
                        class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D]">
                        Confirm Disapproval
                    </x-button>
                </div>
            </div>
        </div>
    </x-modal>
</div>