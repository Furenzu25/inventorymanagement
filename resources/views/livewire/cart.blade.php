<div>
    <x-nav sticky full-width class="bg-black/80 backdrop-blur-md border-b border-red-500/30 z-50">
        <x-slot:brand>
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                <x-icon name="o-cube-transparent" class="w-12 h-12 text-red-500 group-hover:animate-spin transition-all duration-300" />
                <span id="brandName" class="font-bold text-3xl text-red-500 font-['Orbitron'] group-hover:text-purple-400 transition-all duration-300">
                    Rosels Trading
                </span>
            </a>
        </x-slot:brand>
        <x-slot:actions>
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart') }}" class="text-red-500 hover:text-red-400 transition-all duration-300 relative">
                    <x-icon name="o-shopping-cart" class="w-6 h-6" />
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button icon="o-user-circle" class="btn-ghost text-red-500 hover:text-red-400" />
                    </x-slot:trigger>
                    <x-menu-item title="Edit Profile" icon="o-user-circle" wire:click="$emit('openEditProfileModal')" />
                    <x-menu-item title="Logout" icon="o-arrow-left-on-rectangle" wire:click="logout" />
                </x-dropdown>
            </div>
        </x-slot:actions>
    </x-nav>

    <div wire:poll.5s="refreshCart">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-black/30 backdrop-blur-md border border-red-500/30 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-red-500 mb-6">Your Cart</h2>
                    
                    @if(!empty($cartItems) && count($cartItems) > 0)
                        @foreach($cartItems as $index => $item)
                            <div class="flex justify-between items-center border-b border-red-500/30 py-4">
                                <div>
                                    <h3 class="text-lg text-red-400">{{ $item['name'] }}</h3>
                                    <p class="text-gray-400">Quantity: {{ $item['quantity'] }}</p>
                                    <p class="text-gray-400">Price: ${{ number_format($item['price'], 2) }}</p>
                                </div>
                                <button wire:click="removeItem({{ $index }})" class="text-red-500 hover:text-red-400">
                                    Remove
                                </button>
                            </div>
                        @endforeach
                        
                        <div class="mt-6">
                            <p class="text-xl text-red-500">Total: ${{ number_format($this->getTotal(), 2) }}</p>
                        </div>
                        
                        <div class="mt-4">
                            <label for="loanDuration" class="block text-sm font-medium text-red-400">Loan Duration (months)</label>
                            <select id="loanDuration" wire:model="loanDuration" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-red-500/30 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md bg-black/30 text-red-400">
                                <option value="6">6 months</option>
                                <option value="12">12 months</option>
                                <option value="24">24 months</option>
                                <option value="36">36 months</option>
                            </select>
                        </div>
                        
                        <div class="mt-6">
                            <button wire:click="submitPreorder" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
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
</div>
