<div>
    <div x-data="{ open: @entangle('showModal') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Reject Payment</h3>
                    
                    <div class="space-y-4">
                        <p class="text-[#401B1B]">Are you sure you want to reject this payment?</p>
                        
                        <div class="bg-white/50 p-4 rounded-lg">
                            <p class="text-[#72383D]">Amount: ₱{{ number_format($submission->amount ?? 0, 2) }}</p>
                            <p class="text-[#72383D]">Customer: {{ $submission->customer->name ?? 'N/A' }}</p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <x-button 
                                wire:click="$set('showModal', false)"
                                class="bg-[#AB644B] hover:bg-[#72383D] text-white"
                                label="Cancel"
                            />
                            <x-button 
                                wire:click="rejectPayment"
                                class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white"
                                label="Reject"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 