<div>
    <!-- Payment Modal -->
    <div x-data="{ open: @entangle('showModal') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Submit Payment</h3>

                    <form wire:submit="submitPayment" class="space-y-6">
                        <!-- Account Receivable Selection -->
                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Select Account to Pay</label>
                            <select 
                                wire:model.live="selectedAR"
                                class="w-full rounded-lg border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                            >
                                <option value="">Select an account...</option>
                                @foreach($accountReceivables as $ar)
                                    <option value="{{ $ar->id }}">
                                        {{ $ar->preorder->preorderItems->first()->product->product_name }} - 
                                        Remaining: ₱{{ number_format($ar->remaining_balance, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedAR') 
                                <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Due Amount Display -->
                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Due Amount</label>
                            <div class="text-lg font-bold text-[#72383D]">
                                ₱{{ number_format($dueAmount, 2) }}
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Amount to Pay</label>
                            <x-input 
                                wire:model="amount"
                                type="number"
                                step="0.01"
                                placeholder="Enter payment amount"
                                class="mt-1 block w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                            />
                            @error('amount') 
                                <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Payment Proof -->
                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Payment Proof</label>
                            <input 
                                type="file"
                                wire:model="paymentProof"
                                class="mt-1 block w-full text-sm text-[#401B1B]
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-[#72383D] file:text-white
                                    hover:file:bg-[#401B1B]"
                            />
                            @error('paymentProof') 
                                <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Payment Date -->
                        <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Payment Date</label>
                            <x-input 
                                wire:model="paymentDate"
                                type="date"
                                class="mt-1 block w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                            />
                            @error('paymentDate') 
                                <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <x-button 
                                type="button"
                                wire:click="$set('showModal', false)"
                                class="bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300"
                                label="Cancel"
                            />
                            <x-button 
                                type="submit"
                                class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300"
                                label="Submit Payment"
                            />
                        </div>
                    </form>

                    <!-- Close Button -->
                    <button 
                        type="button"
                        wire:click="$set('showModal', false)"
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
</div> 