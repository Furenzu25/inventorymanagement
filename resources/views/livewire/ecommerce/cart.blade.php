<div>
    <x-nav sticky full-width class="bg-[#2c3e50]/80 backdrop-blur-md border-b border-[#3498db]/30 z-50">
        <x-slot:brand>
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                <x-icon name="o-cube-transparent" class="w-12 h-12 text-[#3498db] group-hover:animate-spin transition-all duration-300" />
                <span id="brandName" class="font-bold text-3xl text-[#3498db] font-['Poppins'] group-hover:text-[#2ecc71] transition-all duration-300">
                    Rosels Trading
                </span>
            </a>
        </x-slot:brand>
        <x-slot:actions>
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart') }}" class="text-[#3498db] hover:text-[#2ecc71] transition-all duration-300 relative">
                    <x-icon name="o-shopping-cart" class="w-6 h-6" />
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-[#3498db] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button icon="o-user-circle" class="btn-ghost text-[#3498db] hover:text-[#2ecc71]" />
                    </x-slot:trigger>
                    <x-menu-item title="Edit Profile" icon="o-user-circle" wire:click="$dispatch('openProfileManagement')" />
                    <x-menu-item title="Logout" icon="o-arrow-left-on-rectangle" wire:click="logout" />
                </x-dropdown>
            </div>
        </x-slot:actions>
    </x-nav>

    <div wire:poll.5s="refreshCart">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-[#2c3e50]/30 backdrop-blur-md border border-[#3498db]/30 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-[#3498db] mb-6">Your Cart</h2>
                    
                    @if(!empty($cartItems) && count($cartItems) > 0)
                        @foreach($cartItems as $index => $item)
                            <div class="flex justify-between items-center border-b border-[#3498db]/30 py-4">
                                <div>
                                    <h3 class="text-lg text-[#3498db]">{{ $item['name'] }}</h3>
                                    <p class="text-gray-400">Quantity: {{ $item['quantity'] }}</p>
                                    <p class="text-gray-400">Price: ₱{{ number_format($item['price'], 2) }}</p>
                                </div>
                                <button wire:click="removeItem({{ $index }})" class="text-[#3498db] hover:text-[#2ecc71]">
                                    Remove
                                </button>
                            </div>
                        @endforeach
                        
                        <div class="mt-6">
                            <p class="text-xl text-[#3498db]">Total: ₱{{ number_format($this->getTotal(), 2) }}</p>
                        </div>
                        
                        <div class="mt-4">
                            <label for="loanDuration" class="block text-sm font-medium text-[#3498db]">Loan Duration (months)</label>
                            <select id="loanDuration" wire:model="loanDuration" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[#3498db]/30 focus:outline-none focus:ring-[#3498db] focus:border-[#3498db] sm:text-sm rounded-md bg-[#2c3e50] text-[#3498db]">
                                <option value="6">6 months</option>
                                <option value="12">12 months</option>
                                <option value="24">24 months</option>
                                <option value="36">36 months</option>
                            </select>
                        </div>
                        
                        <div class="mt-6">
                            <button wire:click="submitPreorder" class="bg-[#3498db] hover:bg-[#2980b9] text-white font-bold py-2 px-4 rounded">
                                Submit Pre-order
                            </button>
                        </div>
                    @else
                        <p class="text-gray-400">Your cart is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center">
        <a href="{{ route('customer.orders') }}" class="text-blue-600 hover:text-blue-800">
            View My Orders
        </a>
        <!-- Other cart actions -->
    </div>
</div>
