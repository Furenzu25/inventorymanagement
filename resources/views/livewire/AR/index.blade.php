<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <x-header title="Account Receivables Management" class="text-[#401B1B] text-3xl font-bold" />
        <div class="flex space-x-2 mt-4 md:mt-0">
            <x-input 
                icon="o-magnifying-glass" 
                placeholder="Search AR..." 
                wire:model.live="search" 
                class="pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-md shadow-sm"
            />
            
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <x-stat
            value="{{ number_format($totalAR, 2) }}"
            icon="o-currency-dollar"
            class="bg-gradient-to-br from-[#401B1B] to-[#72383D] text-white shadow-lg rounded-lg"
        >
            <x-slot:title>
                <span class="text-[#F2F2EB] font-semibold">Total AR</span>
            </x-slot:title>
        </x-stat>

        <x-stat
            value="{{ number_format($totalOutstanding, 2) }}"
            icon="o-exclamation-circle"
            class="bg-gradient-to-br from-[#72383D] to-[#AB644B] text-white shadow-lg rounded-lg"
        >
            <x-slot:title>
                <span class="text-[#F2F2EB] font-semibold">Total Outstanding</span>
            </x-slot:title>
        </x-stat>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                            <th class="px-4 py-2 text-left">Order ID</th>
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Product</th>
                            <th class="px-4 py-2 text-left">Monthly Payment</th>
                            <th class="px-4 py-2 text-left">Total Paid</th>
                            <th class="px-4 py-2 text-left">Remaining Balance</th>
                            <th class="px-4 py-2 text-left">Loan Duration</th>
                            <th class="px-4 py-2 text-left">Next Payment Due</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accountReceivables as $ar)
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-2 text-[#401B1B]">
                                    #{{ $ar->preorder_id }}
                                </td>
                                <td class="px-4 py-2 text-[#401B1B]">{{ $ar->customer->name }}</td>
                                <td class="px-4 py-3">
                                    @foreach($ar->preorder->preorderItems as $item)
                                        <div class="text-[#401B1B] font-medium">
                                            {{ $item->product->product_name }}
                                            @if(!$loop->last)
                                                <br>
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2 text-[#401B1B]">₱{{ number_format($ar->monthly_payment, 2) }}</td>
                                <td class="px-4 py-2 text-[#401B1B]">₱{{ number_format($ar->total_paid, 2) }}</td>
                                <td class="px-4 py-2 text-[#401B1B]">₱{{ number_format($ar->remaining_balance, 2) }}</td>
                                <td class="px-4 py-2 text-[#401B1B]">
                                    @if($ar->loan_start_date && $ar->loan_end_date)
                                        <div>{{ $ar->loan_start_date->format('M d, Y') }} -</div>
                                        <div>{{ $ar->loan_end_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-600">
                                            ({{ $ar->loan_start_date->diffInMonths($ar->loan_end_date) }} months)
                                        </div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if($ar->status === 'ongoing')
                                        @php
                                            $nextDueDate = $ar->getNextPaymentDueDate();
                                        @endphp
                                        @if($nextDueDate)
                                            <div class="text-[#401B1B]">
                                                {{ $nextDueDate->format('M d, Y') }}
                                                @if($nextDueDate->isPast())
                                                    <span class="text-red-500 text-xs">(Overdue)</span>
                                                @else
                                                    <span class="text-[#72383D] text-xs">({{ $nextDueDate->diffForHumans() }})</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-[#401B1B]">N/A</span>
                                        @endif
                                    @else
                                        <span class="text-[#401B1B]">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-sm rounded-full {{ $ar->status === 'paid' ? 'bg-[#72383D] text-white' : 'bg-[#AB644B] text-white' }}">
                                        {{ ucfirst($ar->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @if($ar->status === 'ongoing')
                                        <x-button wire:click="reassignProduct({{ $ar->id }})" 
                                                class="bg-[#9CABB4] hover:bg-[#72383D] text-white text-xs py-1 px-2 rounded transition duration-300"
                                                onclick="confirm('Are you sure you want to repossess this product?') || event.stopImmediatePropagation()">
                                            Repossess
                                        </x-button>
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