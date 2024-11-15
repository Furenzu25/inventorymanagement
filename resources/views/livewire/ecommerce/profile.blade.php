<div class="relative z-10">
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
                <a href="{{ route('home') }}" class="text-[#3498db] hover:text-[#2ecc71] transition-all duration-300">
                    <x-icon name="o-home" class="w-6 h-6" />
                </a>
            </div>
        </x-slot:actions>
    </x-nav>

    <div class="min-h-screen bg-[#1a2634] py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2c3e50]/30 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Profile Sidebar -->
                        <div class="md:w-1/4">
                            <div class="text-center mb-6">
                                <div class="relative w-32 h-32 mx-auto mb-4">
                                    @if($customer['profile_image'])
                                        <img src="{{ Storage::url($customer['profile_image']) }}" alt="Profile" class="rounded-full w-full h-full object-cover border-4 border-[#3498db]">
                                    @else
                                        <div class="w-full h-full rounded-full bg-[#2c3e50] flex items-center justify-center border-4 border-[#3498db]">
                                            <x-icon name="o-user" class="w-16 h-16 text-[#3498db]" />
                                        </div>
                                    @endif
                                </div>
                                <div class="relative group">
                                    <input type="file" wire:model="profileImage" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    <button class="text-[#3498db] hover:text-[#2ecc71] text-sm">Change Profile Picture</button>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-200 mt-4">{{ $customer['name'] }}</h2>
                                <p class="text-[#3498db]">{{ $customer['email'] }}</p>
                            </div>

                            <nav class="space-y-2">
                                <button wire:click="switchTab('profile')" 
                                    class="w-full text-left px-4 py-2 rounded {{ $currentTab === 'profile' ? 'bg-[#3498db] text-white' : 'text-gray-200 hover:bg-[#2c3e50]' }} transition-all duration-300">
                                    Profile Information
                                </button>
                                <button wire:click="switchTab('orders')" 
                                    class="w-full text-left px-4 py-2 rounded {{ $currentTab === 'orders' ? 'bg-[#3498db] text-white' : 'text-gray-200 hover:bg-[#2c3e50]' }} transition-all duration-300">
                                    Order History
                                </button>
                            </nav>
                        </div>

                        <!-- Main Content -->
                        <div class="md:w-3/4">
                            @if($currentTab === 'profile')
                                <form wire:submit.prevent="updateProfile" class="text-gray-200">
                                    <div class="space-y-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <x-input label="Name" wire:model="customer.name" class="bg-[#2c3e50]" />
                                            <x-input label="Email" type="email" wire:model="customer.email" class="bg-[#2c3e50]" />
                                            <x-input label="Birthday" type="date" wire:model="customer.birthday" class="bg-[#2c3e50]" />
                                            <x-input label="Phone Number" wire:model="customer.phone_number" class="bg-[#2c3e50]" />
                                        </div>

                                        <x-textarea label="Address" wire:model="customer.address" class="bg-[#2c3e50]" />

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <x-input label="Reference Contact Person" wire:model="customer.reference_contactperson" class="bg-[#2c3e50]" />
                                            <x-input label="Reference Contact Phone" wire:model="customer.reference_contactperson_phonenumber" class="bg-[#2c3e50]" />
                                            <x-input label="Valid ID Number" wire:model="customer.valid_id" class="bg-[#2c3e50]" />
                                            <div class="relative group">
                                                <input type="file" wire:model="validIdImage" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                                <button type="button" class="w-full px-4 py-2 text-[#3498db] border border-[#3498db] rounded hover:bg-[#3498db] hover:text-white transition-all duration-300">
                                                    Upload Valid ID
                                                </button>
                                            </div>
                                        </div>

                                        @if($customer['valid_id_image'])
                                            <div class="mt-4">
                                                <label class="block text-sm font-medium text-gray-200">Current Valid ID</label>
                                                <img src="{{ Storage::url($customer['valid_id_image']) }}" alt="Valid ID" class="mt-2 max-w-md rounded-lg border border-[#3498db]">
                                            </div>
                                        @endif

                                        <div class="flex justify-end">
                                            <x-button type="submit" class="bg-[#3498db] hover:bg-[#2ecc71] text-white transition-all duration-300">
                                                Save Changes
                                            </x-button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                @livewire('customers.orders')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>