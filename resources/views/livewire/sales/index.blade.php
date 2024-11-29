<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#401B1B]">Sales Overview</h1>
            <p class="text-[#72383D] mt-1">Manage and track all sales transactions</p>
        </div>
        
        <!-- Summary Cards -->
        <div class="flex gap-4">
            <div class="bg-white/80 rounded-xl p-4 shadow-md border border-[#72383D]/10">
                <p class="text-sm text-[#72383D]">Total Sales</p>
                <p class="text-2xl font-bold text-[#401B1B]">₱{{ number_format($sales->sum('total_amount'), 2) }}</p>
            </div>
            <div class="bg-white/80 rounded-xl p-4 shadow-md border border-[#72383D]/10">
                <p class="text-sm text-[#72383D]">Total Interest</p>
                <p class="text-2xl font-bold text-[#401B1B]">₱{{ number_format($sales->sum('interest_earned'), 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center">
            <!-- Search Bar -->
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-[#72383D]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <x-input 
                    placeholder="Search customers..." 
                    wire:model.live.debounce.300ms="search" 
                    class="pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-lg"
                />
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                            <th class="px-6 py-3 text-left text-sm font-semibold">Sale ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Type</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Customer</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Total Amount</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Interest Earned</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Completion Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#72383D]/10">
                        @foreach($sales as $sale)
                            <tr class="hover:bg-[#F2F2EB]/50 transition-colors duration-200">
                                <td class="px-6 py-4 text-[#401B1B] font-medium">#{{ $sale->id }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                        {{ $sale->type === 'loan' ? 'bg-[#AB644B]' : 'bg-[#72383D]' }} text-white">
                                        {{ ucfirst($sale->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-[#401B1B] font-medium">{{ $sale->customer->name }}</div>
                                    <div class="text-[#72383D] text-sm">ID: #{{ $sale->customer->id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-[#401B1B] font-medium">₱{{ number_format($sale->total_amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-[#72383D]">₱{{ number_format($sale->interest_earned, 2) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-[#401B1B]">{{ $sale->completion_date->setTimezone('Asia/Manila')->format('M d, Y') }}</div>
                                    <div class="text-[#72383D] text-sm">{{ $sale->completion_date->setTimezone('Asia/Manila')->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
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