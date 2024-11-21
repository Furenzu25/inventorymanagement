<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    @include('livewire.ecommerce.components.nav-bar')
    
    <div wire:poll.5s="refreshCart" class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                <div class="p-8 sm:p-12">
                    <h2 class="text-3xl font-bold text-[#401B1B] mb-8">Your Cart</h2>
                    
                    @if(!empty($cartItems) && count($cartItems) > 0)
                        <div class="space-y-6">
                            @foreach($cartItems as $index => $item)
                                <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-xl font-semibold text-[#401B1B]">{{ $item['name'] }}</h3>
                                            <p class="text-[#72383D]">Quantity: {{ $item['quantity'] }}</p>
                                            <p class="text-[#72383D]">Price: ₱{{ number_format($item['price'], 2) }}</p>
                                        </div>
                                        <button wire:click="removeItem({{ $index }})" 
                                                class="text-[#AB644B] hover:text-[#401B1B] transition-all duration-300">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                <p class="text-2xl font-bold text-[#401B1B]">Total: ₱{{ number_format($this->getTotal(), 2) }}</p>
                            </div>
                            
                            <div class="mt-8 space-y-4">
                                <div>
                                    <label for="loanDuration" class="block text-sm font-medium text-[#401B1B]">
                                        Loan Duration
                                    </label>
                                    <select wire:model="loanDuration" id="loanDuration" 
                                        class="mt-1 block w-full rounded-md border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                                        @foreach($loanDurationOptions as $months => $label)
                                            <option value="{{ $months }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('loanDuration') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="paymentMethod" class="block text-sm font-medium text-[#401B1B]">
                                        Payment Method
                                    </label>
                                    <select wire:model="paymentMethod" id="paymentMethod" 
                                        class="mt-1 block w-full rounded-md border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                                        <option value="">Select payment method</option>
                                        @foreach($paymentMethods as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('paymentMethod') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button wire:click="submitPreorder" 
                                    class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white py-2 px-4 rounded-md hover:from-[#401B1B] hover:to-[#72383D] transition-all duration-300">
                                    Submit Pre-order
                                </button>
                            </div>
                        </div>
                    @else
                        <p class="text-[#72383D] text-center text-lg">Your cart is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
