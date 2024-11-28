<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    @include('livewire.ecommerce.components.nav-bar')
    
    <div class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-[#401B1B] mb-8">Payment History</h2>

                    @forelse($accountReceivables as $ar)
                        <div class="mb-8 bg-white/50 rounded-xl p-6">
                            <h3 class="text-xl font-semibold text-[#401B1B] mb-4">
                                {{ $ar->preorder->preorderItems->first()->product->product_name }}
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                <div>
                                    <p class="text-[#72383D]">Total Amount: ₱{{ number_format($ar->total_amount, 2) }}</p>
                                    <p class="text-[#72383D]">Monthly Payment: ₱{{ number_format($ar->monthly_payment, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-[#72383D]">Remaining Balance: ₱{{ number_format($ar->remaining_balance, 2) }}</p>
                                    <p class="text-[#72383D]">Status: {{ ucfirst($ar->status) }}</p>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-[#72383D]/10">
                                    <thead class="bg-[#F2F2EB]/50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Amount Paid</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Balance After Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white/50 divide-y divide-[#72383D]/10">
                                        @forelse($ar->payments as $payment)
                                            <tr class="hover:bg-[#F2F2EB]/50">
                                                <td class="px-6 py-4 whitespace-nowrap text-[#401B1B]">
                                                    {{ $payment->payment_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 text-[#72383D] font-medium">
                                                    ₱{{ number_format($payment->amount_paid, 2) }}
                                                </td>
                                                <td class="px-6 py-4 text-[#72383D]">
                                                    ₱{{ number_format($payment->remaining_balance, 2) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-4 text-center text-[#72383D]">
                                                    No payments recorded yet
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <p class="text-[#72383D] text-center text-lg">No payment history found</p>
                    @endforelse

                    @if($paymentSubmissions->isNotEmpty())
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold text-[#401B1B] mb-4">Pending Submissions</h3>
                            @include('livewire.customers.payment-history._pending_submissions')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 