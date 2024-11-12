<div class="bg-gray-100 min-h-screen p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Customer Payments</h1>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="mb-4">
                <x-input 
                    placeholder="Search customers..." 
                    wire:model.debounce="search" 
                    class="w-64" 
                />
            </div>

            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total AR</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($customers as $customer)
                            <tr>
                                <td class="px-6 py-4">{{ $customer->name }}</td>
                                <td class="px-6 py-4">{{ $customer->accountReceivables->count() }} (₱{{ number_format($customer->accountReceivables->sum('total_amount'), 2) }})</td>
                                <td class="px-6 py-4">
                                    <x-button 
                                        label="View Payments" 
                                        wire:click="viewPaymentHistory({{ $customer->id }})" 
                                        class="bg-blue-500 hover:bg-blue-600"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    <!-- Payment History Modal -->
    <x-modal wire:model="paymentHistoryOpen">
        <x-card title="Payment History - {{ $selectedCustomer?->name }}" class="font-inter">
            @if($selectedCustomer)
                <!-- AR Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Select Account Receivable</label>
                    <select wire:model="selectedAR" wire:change="selectAR($event.target.value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Select an AR</option>
                        @foreach($selectedCustomer->accountReceivables as $ar)
                            <option value="{{ $ar->id }}">
                                AR #{{ $ar->id }} - {{ $ar->preorder->preorderItems->map(function($item) { return $item->product->product_name; })->implode(', ') }}
                                (₱{{ number_format($ar->remaining_balance, 2) }} remaining)
                            </option>
                        @endforeach
                    </select>
                </div>

                @if($selectedAR)
                    <!-- Payment History Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Payment Date</th>
                                    <th class="px-4 py-2 text-left">Amount Paid</th>
                                    <th class="px-4 py-2 text-left">Due Amount</th>
                                    <th class="px-4 py-2 text-left">Remaining Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selectedCustomerPayments as $payment)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ date('M d, Y', strtotime($payment->payment_date)) }}</td>
                                        <td class="px-4 py-2">₱{{ number_format($payment->amount_paid, 2) }}</td>
                                        <td class="px-4 py-2">₱{{ number_format($payment->due_amount, 2) }}</td>
                                        <td class="px-4 py-2">₱{{ number_format($payment->remaining_balance, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <x-button 
                            wire:click="showRecordPayment"
                            class="bg-green-500 hover:bg-green-600 text-white"
                            label="Record New Payment"
                        />
                    </div>
                @endif
            @endif
        </x-card>
    </x-modal>

    <!-- Record Payment Modal -->
    <x-modal wire:model="recordPaymentOpen">
        <x-card title="Record Payment - {{ $selectedCustomer->name ?? '' }}">
            <div class="space-y-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Monthly Due Amount</label>
                    <x-input 
                        value="{{ $payment['due_amount'] }}"
                        type="number" 
                        step="0.01"
                        readonly
                        disabled
                        class="mt-1 block w-full"
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Amount to Pay</label>
                    <x-input 
                        wire:model.defer="payment.amount_paid" 
                        type="number" 
                        step="0.01"
                        placeholder="Enter payment amount"
                        class="mt-1 block w-full"
                    />
                    @error('payment.amount_paid') 
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Payment Date</label>
                    <x-input 
                        wire:model.defer="payment.payment_date" 
                        type="date"
                        class="mt-1 block w-full"
                    />
                    @error('payment.payment_date') 
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-button 
                        wire:click="recordPayment"
                        class="w-full"
                        label="Submit Payment"
                        positive
                    />
                </div>
            </div>
        </x-card>
    </x-modal>
</div>
