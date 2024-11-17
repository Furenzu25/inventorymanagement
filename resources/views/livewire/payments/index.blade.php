<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-[#401B1B]">Customer Payments</h1>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="mb-4 flex items-center">
                <div class="relative w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#72383D]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <x-input 
                        placeholder="Search customers..." 
                        wire:model.live.debounce.300ms="search" 
                        class="pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-md shadow-sm"
                    />
                </div>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-[#72383D] text-white rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-[#AB644B] text-white rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#D2DCE6]">
                    <thead class="bg-[#F2F2EB]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Account Receivables</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#D2DCE6]">
                        @foreach($customers as $customer)
                            <tr class="hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-6 py-4 text-[#401B1B]">{{ $customer->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        @foreach($customer->accountReceivables as $ar)
                                            <div class="flex flex-col gap-1">
                                                <div class="text-sm text-[#401B1B]">
                                                    AR #{{ $ar->id }} - 
                                                    {{ $ar->preorder->preorderItems->map(function($item) { 
                                                        return $item->product->product_name; 
                                                    })->implode(', ') }}
                                                </div>
                                                <div class="text-sm text-[#72383D] font-medium">
                                                    @if($ar->remaining_balance <= 0)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Fully Paid
                                                        </span>
                                                    @else
                                                        Remaining Balance: ₱{{ number_format($ar->remaining_balance, 2) }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <x-button 
                                        label="View Payments" 
                                        wire:click="viewPaymentHistory({{ $customer->id }})" 
                                        class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300 shadow-md"
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
    <div x-data="{ open: @entangle('paymentHistoryOpen') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-4xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Payment History - {{ $selectedCustomer?->name }}</h3>

                    @if (session()->has('message'))
                        <div class="mb-6 p-4 bg-[#72383D] text-white rounded-lg">
                            {{ session('message') }}
                        </div>
                    @endif
                    
                    @if($selectedCustomer)
                        <!-- AR Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Select Account Receivable</label>
                            <select wire:model="selectedAR" wire:change="selectAR($event.target.value)" 
                                class="mt-1 block w-full rounded-md border-[#72383D]/20 shadow-md focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 focus:ring-opacity-50 bg-white/80 transition-all duration-300">
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
                            <div class="overflow-x-auto rounded-lg border border-[#72383D]/10 shadow-lg">
                                <table class="min-w-full divide-y divide-[#72383D]/10">
                                    <thead class="bg-gradient-to-r from-[#72383D]/10 to-[#AB644B]/10">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Payment Date</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Amount Paid</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Due Amount</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Remaining Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white/50 divide-y divide-[#72383D]/10">
                                        @foreach($selectedCustomerPayments as $payment)
                                            <tr class="hover:bg-[#F2F2EB]/50 transition-colors duration-300">
                                                <td class="px-6 py-4 text-[#401B1B]">{{ date('M d, Y', strtotime($payment->payment_date)) }}</td>
                                                <td class="px-6 py-4 text-[#401B1B] font-medium">₱{{ number_format($payment->amount_paid, 2) }}</td>
                                                <td class="px-6 py-4 text-[#401B1B]">₱{{ number_format($payment->due_amount, 2) }}</td>
                                                <td class="px-6 py-4 text-[#401B1B]">₱{{ number_format($payment->remaining_balance, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6">
                                <x-button 
                                    wire:click="showRecordPayment"
                                    class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300 shadow-md"
                                    label="Record New Payment"
                                />
                            </div>
                        @endif
                    @endif

                    <!-- Close Button -->
                    <button 
                        wire:click="closePaymentHistory" 
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

    <!-- Record Payment Modal -->
    <div x-data="{ open: @entangle('recordPaymentOpen') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Record Payment - {{ $selectedCustomer?->name }}</h3>

                    @if (session()->has('message'))
                        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg flex items-center justify-between">
                            <span>{{ session('message') }}</span>
                            <span class="text-sm">Redirecting to payment history...</span>
                        </div>
                    @endif

                    <div class="space-y-6">
                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Monthly Due Amount</label>
                            <x-input 
                                value="{{ $payment['due_amount'] }}"
                                type="number" 
                                step="0.01"
                                readonly
                                disabled
                                class="mt-1 block w-full bg-[#D2DCE6]/50 border-[#72383D]/20 shadow-sm"
                            />
                        </div>

                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Remaining Balance</label>
                            <x-input 
                                :value="$selectedAR ? number_format($this->calculatedRemainingBalance, 2) : '0.00'"
                                wire:model.live="calculatedRemainingBalance"
                                type="text" 
                                readonly
                                disabled
                                class="mt-1 block w-full bg-[#D2DCE6]/50 border-[#72383D]/20 shadow-sm"
                            />
                        </div>

                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Amount to Pay</label>
                            <x-input 
                                wire:model.live="payment.amount_paid" 
                                type="number" 
                                step="0.01"
                                placeholder="Enter payment amount"
                                class="mt-1 block w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                            />
                            @error('payment.amount_paid') 
                                <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Payment Date</label>
                            <x-input 
                                wire:model.defer="payment.payment_date" 
                                type="date"
                                class="mt-1 block w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                            />
                            @error('payment.payment_date') 
                                <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <x-button 
                                wire:click="recordPayment"
                                wire:loading.attr="disabled"
                                class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300 shadow-md"
                                label="Submit Payment"
                            >
                                <span wire:loading.remove>Submit Payment</span>
                                <span wire:loading>Recording Payment...</span>
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>