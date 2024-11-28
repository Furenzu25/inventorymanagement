<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <x-header title="Sales" class="text-[#401B1B] mb-6">
        <x-slot:actions>
            <x-input icon="o-magnifying-glass" placeholder="Search sales..." wire:model.live="search" class="w-64" />
        </x-slot:actions>
    </x-header>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                            <th class="px-4 py-2 text-left">Sale ID</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Total Amount</th>
                            <th class="px-4 py-2 text-left">Interest Earned</th>
                            <th class="px-4 py-2 text-left">Completion Date</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr class="border-b hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-2 text-[#401B1B]">#{{ $sale->id }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $sale->type === 'loan' ? 'bg-[#AB644B]' : 'bg-[#72383D]' }} text-white">
                                        {{ ucfirst($sale->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-[#401B1B]">{{ $sale->customer->name }}</td>
                                <td class="px-4 py-2 text-[#401B1B]">₱{{ number_format($sale->total_amount, 2) }}</td>
                                <td class="px-4 py-2 text-[#401B1B]">₱{{ number_format($sale->interest_earned, 2) }}</td>
                                <td class="px-4 py-2 text-[#401B1B]">{{ $sale->completion_date->format('M d, Y') }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $sale->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>