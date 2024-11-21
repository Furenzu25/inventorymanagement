<div class="bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen" x-data="{ showReasonModal: false, currentReason: '' }">
    @include('livewire.ecommerce.components.nav-bar')
    
    <div class="p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#401B1B]">Payment History</h1>
                <x-button 
                    wire:click="$dispatch('openPaymentModal')"
                    class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white"
                    label="Submit New Payment"
                />
            </div>

            @if(session()->has('message'))
                <div class="mb-4 p-4 bg-[#72383D]/10 border-l-4 border-[#72383D] text-[#401B1B] rounded">
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-lg rounded-lg">
                @if($paymentSubmissions->isEmpty())
                    <div class="p-8 text-center text-[#72383D]">
                        <p>No payment submissions found.</p>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-[#72383D]/10">
                        <thead class="bg-[#F2F2EB]/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/50 divide-y divide-[#72383D]/10">
                            @foreach($paymentSubmissions as $submission)
                                <tr class="hover:bg-[#F2F2EB]/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-[#401B1B]">
                                        {{ $submission->payment_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-[#401B1B]">
                                        {{ $submission->accountReceivable->preorder->preorderItems->first()->product->product_name }}
                                    </td>
                                    <td class="px-6 py-4 text-[#72383D] font-medium">
                                        ₱{{ number_format($submission->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $submission->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $submission->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex space-x-4">
                                        <a href="{{ Storage::url($submission->payment_proof) }}" 
                                           target="_blank"
                                           class="text-[#72383D] hover:text-[#401B1B] underline">
                                            View Proof
                                        </a>

                                        @if($submission->status === 'rejected' && $submission->rejection_reason)
                                            <button 
                                                type="button"
                                                @click="showReasonModal = true; currentReason = '{{ addslashes($submission->rejection_reason) }}'"
                                                class="text-red-600 hover:text-red-800 underline">
                                                View Reason
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <livewire:customers.submit-payment />

    @push('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush

    <div x-show="showReasonModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="showReasonModal = false">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Rejection Reason</h3>
                    
                    <div class="bg-white/50 p-4 rounded-lg">
                        <p class="text-[#72383D]" x-text="currentReason"></p>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-button 
                            @click="showReasonModal = false"
                            class="bg-[#72383D] hover:bg-[#401B1B] text-white"
                            label="Close"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 