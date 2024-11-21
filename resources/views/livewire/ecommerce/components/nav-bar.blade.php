<div>
    <x-nav sticky full-width class="bg-gradient-to-r from-[#401B1B] to-[#72383D] backdrop-blur-md border-b border-[#AB644B]/30 z-50">
        <x-slot:brand>
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                <x-icon name="o-cube-transparent" class="w-12 h-12 text-[#F2F2EB] group-hover:text-[#AB644B] transition-all duration-300" />
                <span class="font-bold text-3xl text-[#F2F2EB] font-['Poppins'] group-hover:text-[#AB644B] transition-all duration-300">
                    Rosels Trading
                </span>
            </a>
        </x-slot:brand>
        <x-slot:actions>
            <div class="flex items-center space-x-6">
                @auth
                    <!-- Home Icon -->
                    <a href="{{ route('home') }}" class="text-[#F2F2EB] hover:text-[#AB644B] transition-all duration-300">
                        <x-icon name="o-home" class="w-8 h-8" />
                    </a>

                    <!-- Notifications Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <div @click="open = !open" class="text-[#F2F2EB] hover:text-[#AB644B] transition-all duration-300 relative cursor-pointer">
                            <x-icon name="o-bell" class="w-8 h-8" />
                            @if($this->unreadCount > 0)
                                <span class="absolute -top-2 -right-2 bg-[#AB644B] text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                    {{ $this->unreadCount }}
                                </span>
                            @endif
                        </div>
                        
                        <div x-show="open" 
                             x-transition
                             class="absolute right-0 mt-2 bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-md w-96 border-2 border-[#72383D]/20 shadow-xl p-4">
                            <div class="max-h-[80vh] overflow-y-auto">
                                @livewire('ecommerce.customer-notifications')
                            </div>
                        </div>
                    </div>

                    <!-- Cart Icon -->
                    <a href="{{ route('cart') }}" class="text-[#F2F2EB] hover:text-[#AB644B] transition-all duration-300 relative">
                        <x-icon name="o-shopping-cart" class="w-8 h-8" />
                        @if($this->cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-[#AB644B] text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                {{ $this->cartCount }}
                            </span>
                        @endif
                    </a>
                    
                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <div @click="open = !open">
                            @if(auth()->user()->customer?->profile_image)
                                <img src="{{ Storage::url(auth()->user()->customer->profile_image) }}" 
                                     alt="Profile" 
                                     class="w-12 h-12 rounded-full object-cover border-3 border-[#F2F2EB] hover:border-[#AB644B] transition-all duration-300 cursor-pointer shadow-md">
                            @else
                                <x-button icon="o-user-circle" class="btn-ghost text-[#F2F2EB] hover:text-[#AB644B] w-12 h-12" />
                            @endif
                        </div>

                        <div x-show="open" 
                             x-transition
                             class="absolute right-0 mt-2 bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg w-48 border-2 border-[#72383D]/20 shadow-xl py-2">
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-gray-800 hover:bg-[#AB644B]/10">
                                <x-icon name="o-user-circle" class="w-5 h-5 mr-2" />
                                Edit Profile
                            </a>
                            <a href="{{ route('customer.orders') }}" class="flex items-center px-4 py-2 text-gray-800 hover:bg-[#AB644B]/10">
                                <x-icon name="o-shopping-bag" class="w-5 h-5 mr-2" />
                                My Orders
                            </a>
                            <a href="{{ route('customer.payments') }}" class="flex items-center px-4 py-2 text-gray-800 hover:bg-[#AB644B]/10">
                                <x-icon name="o-credit-card" class="w-5 h-5 mr-2" />
                                Payments
                            </a>
                            <button wire:click="logout" class="flex items-center w-full px-4 py-2 text-gray-800 hover:bg-[#AB644B]/10">
                                <x-icon name="o-arrow-left-on-rectangle" class="w-5 h-5 mr-2" />
                                Logout
                            </button>
                        </div>
                    </div>
                @endauth
            </div>
        </x-slot:actions>
    </x-nav>

    <!-- Notification Toast -->
    <div
        x-data="{
            messages: [],
            remove(message) {
                this.messages.splice(this.messages.indexOf(message), 1)
            }
        }"
        @cart-updated.window="
            messages.push('Cart has been updated!');
            setTimeout(() => { remove('Cart has been updated!') }, 3000)"
        class="fixed top-20 right-4 z-50 space-y-2"
    >
        <template x-for="message in messages" :key="message">
            <div 
                x-transition
                class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] border-l-4 border-[#72383D] text-[#401B1B] p-4 rounded shadow-lg flex items-center space-x-2"
            >
                <x-icon name="o-check-circle" class="w-5 h-5 text-[#72383D]" />
                <span x-text="message"></span>
            </div>
        </template>
    </div>

    <livewire:customers.submit-payment />
</div>