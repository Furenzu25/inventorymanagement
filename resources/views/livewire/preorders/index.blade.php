<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    @if (session()->has('message'))
        <div class="alert alert-success mb-4 bg-[#72383D] text-white p-4 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <x-header title="Pre-orders" class="text-[#401B1B] text-3xl font-bold" />
        <div class="flex space-x-2 mt-4 md:mt-0">
            <x-input 
                icon="o-magnifying-glass" 
                placeholder="Search pre-orders..." 
                wire:model.live="search" 
                class="pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-md shadow-sm"
            />
            
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Loan Duration</th>
                            <th class="px-4 py-2 text-left">Total Amount</th>
                            <th class="px-4 py-2 text-left">Monthly Payment</th>
                            <th class="px-4 py-2 text-left">Bought Location</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Payment Method</th>
                            <th class="px-4 py-2 text-left">Order Date</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preorders as $preorder)
                            <tr class="border-b hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 flex-shrink-0 mr-3 bg-gradient-to-br from-[#401B1B] to-[#72383D] rounded-full flex items-center justify-center">
                                            <span class="text-xl text-white font-bold">{{ strtoupper(substr($preorder->customer->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-[#401B1B]">{{ $preorder->customer->name }}</p>
                                            <p class="text-sm text-[#72383D]">{{ $preorder->customer->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $preorder->loan_duration }} months</td>
                                <td class="px-4 py-3 text-[#401B1B]">₱{{ number_format($preorder->total_amount, 2) }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">₱{{ number_format($preorder->monthly_payment, 2) }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $preorder->bought_location }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-sm rounded-full {{ $preorder->status === 'Ongoing' ? 'bg-[#AB644B] text-white' : 'bg-[#72383D] text-white' }}">
                                        {{ $preorder->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $preorder->payment_method }}</td>
                                <td class="px-4 py-3 text-[#401B1B]">{{ $preorder->order_date->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        @if($preorder->status === 'Pending')
                                            <x-button wire:click="approvePreorder({{ $preorder->id }})" label="Approve" class="bg-[#72383D] hover:bg-[#401B1B] text-white text-xs py-1 px-2 rounded transition duration-300" />
                                        @endif
                                        <x-button icon="o-pencil" wire:click="edit({{ $preorder->id }})" class="btn-icon btn-xs bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300" />
                                        <x-button 
                                            icon="o-trash" 
                                            wire:click="delete({{ $preorder->id }})" 
                                            wire:confirm="Are you sure?" 
                                            class="btn-icon btn-xs bg-[#AB644B] hover:bg-[#72383D] text-white transition duration-300"
                                        />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">
        {{ $preorders->links() }}
    </div>
</div>