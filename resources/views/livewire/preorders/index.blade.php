<div>
    @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif

    <x-header title="Pre-orders">
        <x-slot:actions>
            <x-button label="Create Pre-order" wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" />
        </x-slot:actions>
    </x-header>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <x-input icon="o-magnifying-glass" placeholder="Search pre-orders..." wire:model.live="search" />
                <div class="flex space-x-2">
                    <x-button icon="o-adjustments-horizontal" label="Filter" class="bg-gray-200 hover:bg-gray-300 text-gray-700" />
                    <x-button icon="o-arrows-up-down" label="Sort" class="bg-gray-200 hover:bg-gray-300 text-gray-700" />
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-gray-600">Customer</th>
                            <th class="px-4 py-2 text-left text-gray-600">Loan Duration</th>
                            <th class="px-4 py-2 text-left text-gray-600">Total Amount</th>
                            <th class="px-4 py-2 text-left text-gray-600">Monthly Payment</th>
                            <th class="px-4 py-2 text-left text-gray-600">Bought Location</th>
                            <th class="px-4 py-2 text-left text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left text-gray-600">Payment Method</th>
                            <th class="px-4 py-2 text-left text-gray-600">Order Date</th>
                            <th class="px-4 py-2 text-left text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preorders as $preorder)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 flex-shrink-0 mr-3 bg-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-xl text-white font-bold">{{ strtoupper(substr($preorder->customer->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $preorder->customer->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $preorder->customer->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $preorder->loan_duration }} months</td>
                                <td class="px-4 py-3">₱{{ number_format($preorder->total_amount, 2) }}</td>
                                <td class="px-4 py-3">₱{{ number_format($preorder->monthly_payment, 2) }}</td>
                                <td class="px-4 py-3">{{ $preorder->bought_location }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-sm rounded-full {{ $preorder->status === 'Ongoing' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                                        {{ $preorder->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $preorder->payment_method }}</td>
                                <td class="px-4 py-3">{{ $preorder->order_date->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        @if($preorder->status === 'Pending')
                                            <x-button wire:click="approvePreorder({{ $preorder->id }})" label="Approve" class="bg-green-500 hover:bg-green-600 text-white text-xs py-1 px-2 rounded" />
                                        @endif
                                        <x-button icon="o-pencil" wire:click="edit({{ $preorder->id }})" class="btn-icon btn-xs bg-gray-200 hover:bg-gray-300 text-gray-600" />
                                        <x-button 
                                            icon="o-trash" 
                                            wire:click="delete({{ $preorder->id }})" 
                                            wire:confirm="Are you sure?" 
                                            class="btn-icon btn-xs bg-red-200 hover:bg-red-300 text-red-600"
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
