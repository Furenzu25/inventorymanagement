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
                <a href="{{ route('home') }}" class="text-[#F2F2EB] hover:text-[#AB644B] transition-all duration-300">
                    <x-icon name="o-home" class="w-6 h-6" />
                </a>
            </div>
        </x-slot:actions>
    </x-nav>

    <div class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                <div class="p-8 sm:p-12">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Profile Sidebar -->
                        <div class="md:w-1/4">
                            <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                <div class="text-center mb-6">
                                    <div class="relative w-32 h-32 mx-auto mb-4">
                                        @if($profileImage)
                                            <img src="{{ $profileImage->temporaryUrl() }}" 
                                                 alt="Profile Preview" 
                                                 class="rounded-full w-full h-full object-cover border-4 border-[#72383D]">
                                        @elseif($customer['profile_image'])
                                            <img src="{{ Storage::url($customer['profile_image']) }}" 
                                                 alt="Profile" 
                                                 class="rounded-full w-full h-full object-cover border-4 border-[#72383D]">
                                        @else
                                            <div class="w-full h-full rounded-full bg-gradient-to-br from-[#72383D] to-[#AB644B] flex items-center justify-center border-4 border-[#72383D]">
                                                <x-icon name="o-user" class="w-16 h-16 text-white" />
                                            </div>
                                        @endif
                                        
                                        @if($profileProgress)
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full">
                                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="relative group">
                                        <input type="file" 
                                               wire:model.live="profileImage" 
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                               accept="image/*">
                                        <button class="text-[#72383D] hover:text-[#401B1B] text-sm transition-all duration-300">
                                            Change Profile Picture
                                        </button>
                                    </div>
                                    @if(session()->has('profile_message'))
                                        <div class="mt-2 text-sm text-green-600">
                                            {{ session('profile_message') }}
                                        </div>
                                    @endif
                                    <h2 class="text-xl font-semibold text-[#401B1B] mt-4">{{ $customer['name'] }}</h2>
                                    <p class="text-[#72383D]">{{ $customer['email'] }}</p>
                                </div>

                                <nav class="space-y-2">
                                    <button wire:click="switchTab('profile')" 
                                            class="w-full text-left px-4 py-2 rounded-lg transition-all duration-300
                                            {{ $currentTab === 'profile' 
                                                ? 'bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white' 
                                                : 'text-[#401B1B] hover:bg-white/50' }}">
                                        Profile Information
                                    </button>
                                    <button wire:click="switchTab('orders')" 
                                            class="w-full text-left px-4 py-2 rounded-lg transition-all duration-300
                                            {{ $currentTab === 'orders' 
                                                ? 'bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white' 
                                                : 'text-[#401B1B] hover:bg-white/50' }}">
                                        Order History
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="md:w-3/4">
                            <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                @if($currentTab === 'profile')
                                    <form wire:submit.prevent="updateProfile">
                                        <div class="space-y-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <x-input label="Name" wire:model="customer.name" 
                                                         class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                                <x-input label="Email" type="email" wire:model="customer.email" 
                                                         class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                                <x-input label="Birthday" type="date" wire:model="customer.birthday" 
                                                         class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                                <x-input label="Phone Number" wire:model="customer.phone_number" 
                                                         class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                            </div>

                                            <x-textarea label="Address" wire:model="customer.address" 
                                                       class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <x-input label="Reference Contact Person" wire:model="customer.reference_contactperson" 
                                                         class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                                <x-input label="Reference Contact Phone" wire:model="customer.reference_contactperson_phonenumber" 
                                                         class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                                <x-input label="Valid ID Number" wire:model="customer.valid_id" 
                                                         class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                                <div class="relative group">
                                                    <input type="file" 
                                                           wire:model.live="validIdImage" 
                                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                           accept="image/*">
                                                    <button type="button" 
                                                            class="w-full px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white rounded-lg hover:from-[#401B1B] hover:to-[#72383D] transition-all duration-300">
                                                        Upload Valid ID
                                                    </button>
                                                </div>
                                            </div>

                                            @if($validIdProgress)
                                                <div class="mt-2 flex items-center justify-center">
                                                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-[#72383D]"></div>
                                                    <span class="ml-2 text-sm text-[#72383D]">Uploading...</span>
                                                </div>
                                            @endif

                                            @if(session()->has('valid_id_message'))
                                                <div class="mt-2 text-sm text-green-600">
                                                    {{ session('valid_id_message') }}
                                                </div>
                                            @endif

                                            @if($validIdImage)
                                                <div class="mt-4">
                                                    <label class="block text-sm font-medium text-[#401B1B]">Valid ID Preview</label>
                                                    <img src="{{ $validIdImage->temporaryUrl() }}" 
                                                         alt="Valid ID Preview" 
                                                         class="mt-2 max-w-md rounded-lg border border-[#AB644B]/20">
                                                </div>
                                            @elseif($customer['valid_id_image'])
                                                <div class="mt-4">
                                                    <label class="block text-sm font-medium text-[#401B1B]">Current Valid ID</label>
                                                    <img src="{{ Storage::url($customer['valid_id_image']) }}" 
                                                         alt="Valid ID" 
                                                         class="mt-2 max-w-md rounded-lg border border-[#AB644B]/20">
                                                </div>
                                            @endif

                                            <div class="flex justify-end">
                                                <button type="submit" 
                                                        class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105">
                                                    Save Changes
                                                </button>
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
</div>