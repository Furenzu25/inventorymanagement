<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    <x-nav sticky full-width class="bg-gradient-to-r from-[#401B1B] to-[#72383D] backdrop-blur-md border-b border-[#AB644B]/30 z-50">
        <x-slot:brand>
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                <x-icon name="o-cube-transparent" class="w-12 h-12 text-[#F2F2EB] group-hover:text-[#AB644B] transition-all duration-300" />
                <span class="font-bold text-3xl text-[#F2F2EB] font-['Poppins'] group-hover:text-[#AB644B] transition-all duration-300">
                    Rosels Trading
                </span>
            </a>
        </x-slot:brand>
        <x-slot:actions>
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart') }}" class="text-[#F2F2EB] hover:text-[#AB644B] transition-all duration-300 relative">
                    <x-icon name="o-shopping-cart" class="w-6 h-6" />
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-[#AB644B] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button icon="o-user-circle" class="btn-ghost text-[#F2F2EB] hover:text-[#AB644B]" />
                    </x-slot:trigger>
                    <x-menu-item title="Edit Profile" icon="o-user-circle" wire:click="$dispatch('openProfileManagement')" />
                    <x-menu-item title="Logout" icon="o-arrow-left-on-rectangle" wire:click="logout" />
                </x-dropdown>
            </div>
        </x-slot:actions>
    </x-nav>

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
                            
                            <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                <label class="block text-sm font-semibold text-[#401B1B] mb-2">Loan Duration (months)</label>
                                <select wire:model="loanDuration" 
                                        class="w-full rounded-lg border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 bg-white/50">
                                    <option value="6">6 months</option>
                                    <option value="12">12 months</option>
                                    <option value="24">24 months</option>
                                    <option value="36">36 months</option>
                                </select>
                            </div>
                            
                            <div class="mt-8">
                                <button wire:click="submitPreorder" 
                                        class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105">
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
