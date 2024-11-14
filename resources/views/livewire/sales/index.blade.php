<div class="p-6">
    <x-header title="Sales">
        <x-slot:actions>
            <x-input icon="o-magnifying-glass" placeholder="Search sales..." wire:model.live="search" />
        </x-slot:actions>
    </x-header>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Sale ID</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Total Amount</th>
                        <th class="px-4 py-2 text-left">Interest Earned</th>
                        <th class="px-4 py-2 text-left">Completion Date</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        <tr class="border-b">
                            <td class="px-4 py-2">#{{ $sale->id }}</td>
                            <td class="px-4 py-2">{{ $sale->customer->name }}</td>
                            <td class="px-4 py-2">₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td class="px-4 py-2">₱{{ number_format($sale->interest_earned, 2) }}</td>
                            <td class="px-4 py-2">{{ $sale->completion_date->format('M d, Y') }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    {{ $sale->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div> 