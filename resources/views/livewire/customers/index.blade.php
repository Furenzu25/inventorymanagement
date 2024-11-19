<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    @if (session()->has('message'))
        <div class="alert alert-success mb-4 bg-[#72383D] text-white p-4 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger mb-4 bg-[#AB644B] text-white p-4 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="alert alert-info mb-4 bg-[#9CABB4] text-white p-4 rounded-lg">
            {{ session('info') }}
        </div>
    @endif
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <x-header title="Customers" class="text-[#401B1B] text-3xl font-bold" />
        <div class="flex space-x-2 mt-4 md:mt-0">
            <x-input 
                icon="o-magnifying-glass" 
                placeholder="Search customers..." 
                wire:model.live="search" 
                class="pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-md shadow-sm"
            />
            <x-button 
                label="Create Customer" 
                wire:click="create" 
                class="bg-[#72383D] hover:bg-[#401B1B] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out" 
            />
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($customers as $customer)
                    <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition duration-300 ease-in-out">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#401B1B] to-[#72383D] rounded-full flex items-center justify-center text-white text-xl font-bold mr-3">
                                {{ strtoupper(substr($customer['name'], 0, 1)) }}
                            </div>
                            <div class="overflow-hidden">
                                <h3 class="text-base font-semibold text-[#401B1B] truncate">{{ $customer['name'] }}</h3>
                                <p class="text-sm text-[#72383D] truncate">{{ $customer['email'] }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <x-button 
                                label="View details" 
                                wire:click="showCustomerDetails({{ $customer['id'] }})" 
                                class="w-full bg-[#72383D] hover:bg-[#401B1B] text-white text-xs py-1.5 px-2 rounded transition duration-300"
                            />
                            <x-button 
                                label="View Payment" 
                                wire:click="viewPayment({{ $customer['id'] }})" 
                                class="w-full bg-[#AB644B] hover:bg-[#72383D] text-white text-xs py-1.5 px-2 rounded transition duration-300"
                            />
                        </div>
                        <div class="flex justify-end space-x-2">
                            <x-button 
                                icon="o-pencil" 
                                wire:click="edit({{ $customer['id'] }})" 
                                class="btn-icon btn-xs bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300"
                            />
                            <x-button 
                                icon="o-trash" 
                                wire:click="delete({{ $customer['id'] }})" 
                                class="btn-icon btn-xs bg-[#AB644B] hover:bg-[#72383D] text-white transition duration-300" 
                            />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-[#F2F2EB] px-6 py-4 border-t border-[#D2DCE6]">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- Customer Details Modal -->
    <div x-data="{ open: @entangle('customerDetailsOpen') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity" @click="open = false"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-4xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    @if($selectedCustomer)
                        <!-- Header -->
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-[#401B1B]">{{ $selectedCustomer['name'] }}</h2>
                            <div class="h-0.5 bg-[#72383D]/20 mt-2"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Profile Card -->
                                <div class="bg-white/50 p-6 rounded-lg shadow-md">
                                    <div class="flex items-center mb-4">
                                        <div class="w-16 h-16 bg-gradient-to-br from-[#401B1B] to-[#72383D] rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                            {{ strtoupper(substr($selectedCustomer['name'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-semibold text-[#401B1B]">{{ $selectedCustomer['name'] }}</h3>
                                            <p class="text-[#72383D]">{{ $selectedCustomer['email'] }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Contact Information -->
                                    <div class="space-y-2 mt-4">
                                        <div><span class="text-[#401B1B] font-medium">Phone:</span> <span class="text-[#72383D]">{{ $selectedCustomer['phone_number'] }}</span></div>
                                        <div><span class="text-[#401B1B] font-medium">Birthday:</span> <span class="text-[#72383D]">{{ date('F j, Y', strtotime($selectedCustomer['birthday'])) }}</span></div>
                                        <div><span class="text-[#401B1B] font-medium">Address:</span> <span class="text-[#72383D]">{{ $selectedCustomer['address'] }}</span></div>
                                    </div>
                                </div>

                                <!-- Valid ID Information -->
                                <div class="bg-white/50 p-4 rounded-lg shadow-md">
                                    <h3 class="font-bold text-lg mb-3 text-[#401B1B]">Identification</h3>
                                    <div class="space-y-2">
                                        <div><span class="text-[#401B1B] font-medium">Valid ID Type:</span> <span class="text-[#72383D]">{{ $selectedCustomer['valid_id'] }}</span></div>
                                        @if($selectedCustomer['valid_id_image'])
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($selectedCustomer['valid_id_image']) }}" 
                                                     alt="Valid ID" 
                                                     class="w-full h-auto rounded-lg shadow-sm">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Reference Contact -->
                                <div class="bg-white/50 p-4 rounded-lg shadow-md">
                                    <h3 class="font-bold text-lg mb-3 text-[#401B1B]">Reference Contact</h3>
                                    <div class="space-y-2">
                                        <div><span class="text-[#401B1B] font-medium">Contact Person:</span> <span class="text-[#72383D]">{{ $selectedCustomer['reference_contactperson'] }}</span></div>
                                        <div><span class="text-[#401B1B] font-medium">Contact Number:</span> <span class="text-[#72383D]">{{ $selectedCustomer['reference_contactperson_phonenumber'] }}</span></div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="bg-white/50 p-4 rounded-lg shadow-md">
                                    <h3 class="font-bold text-lg mb-3 text-[#401B1B]">Additional Information</h3>
                                    <div class="space-y-2">
                                        <div><span class="text-[#401B1B] font-medium">Customer Since:</span> <span class="text-[#72383D]">{{ date('F j, Y', strtotime($selectedCustomer['created_at'])) }}</span></div>
                                        <div><span class="text-[#401B1B] font-medium">Last Updated:</span> <span class="text-[#72383D]">{{ date('F j, Y', strtotime($selectedCustomer['updated_at'])) }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-6 flex justify-end">
                            <x-button 
                                label="Close" 
                                wire:click="$set('customerDetailsOpen', false)" 
                                class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300" 
                            />
                        </div>
                    @endif

                    <!-- Close Button -->
                    <button 
                        wire:click="$set('customerDetailsOpen', false)"
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History Modal -->
    <div x-data="{ open: @entangle('paymentHistoryOpen') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <div class="relative inline-block p-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-[#F2F2EB] p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-[#401B1B] mb-4">Payment History</h3>
                    @if(count($selectedCustomerPayments) > 0)
                        <div class="space-y-4">
                            @foreach($selectedCustomerPayments as $payment)
                                <div class="border-b border-[#D2DCE6] pb-4">
                                    <div class="text-lg font-medium text-[#401B1B] mb-2">
                                        <span class="font-semibold">Date:</span> 
                                        <span class="text-[#72383D]">{{ $payment['payment_date'] }}</span>
                                    </div>
                                    <div class="text-lg font-medium text-[#401B1B] mb-2">
                                        <span class="font-semibold">Amount Paid:</span> 
                                        <span class="text-[#72383D]">₱{{ number_format($payment['amount_paid'], 2) }}</span>
                                    </div>
                                    <div class="text-lg font-medium text-[#401B1B]">
                                        <span class="font-semibold">Due Amount:</span> 
                                        <span class="text-[#72383D]">₱{{ number_format($payment['due_amount'], 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[#72383D] text-lg">No payment history available for this customer.</p>
                    @endif
                    <div class="mt-4 flex justify-end">
                        <x-button label="Close" wire:click="closePaymentHistory" class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Customer Modal -->
    <div x-data="{ open: @entangle('modalOpen') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity" @click="open = false"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-4xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">{{ $customerId ? 'Edit Customer' : 'Create Customer' }}</h3>
                    
                    <form wire:submit.prevent="store">
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <x-input label="Name" wire:model="customer.name" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Birthday" type="date" wire:model="customer.birthday" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Address" wire:model="customer.address" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Phone Number" wire:model="customer.phone_number" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Email" type="email" wire:model="customer.email" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <x-input label="Reference Contact Person" wire:model="customer.reference_contactperson" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Reference Contact Person Phone" wire:model="customer.reference_contactperson_phonenumber" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                <x-input label="Valid ID" wire:model="customer.valid_id" class="bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30" />
                                
                                <div class="space-y-2">
                                    <x-file 
                                        wire:model="validIdImage" 
                                        label="Valid ID Image"
                                        accept="image/png, image/jpeg, image/jpg, image/gif"
                                        hint="Upload image (max 5MB)"
                                    >
                                        <x-slot:preview>
                                            @if ($validIdImage && $imageUploaded)
                                                <img src="{{ $validIdImage->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-lg" />
                                            @elseif ($existingImage)
                                                <img src="{{ Storage::url($existingImage) }}" class="h-32 w-32 object-cover rounded-lg" />
                                            @else
                                                <div class="h-32 w-32 rounded-lg bg-[#1A1B1E] flex items-center justify-center">
                                                    <x-icon name="o-photo" class="w-8 h-8 text-gray-400" />
                                                </div>
                                            @endif
                                        </x-slot:preview>
                                    </x-file>
                                    
                                    @error('validIdImage') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    
                                    @if ($imageUploaded)
                                        <p class="text-sm text-[#72383D]">New image uploaded. Save to apply changes.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <x-button type="button" wire:click="closeModal" class="bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300">Cancel</x-button>
                            <x-button type="submit" class="bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300">Save</x-button>
                        </div>
                    </form>

                    <!-- Close Button -->
                    <button 
                        wire:click="closeModal" 
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>