<div class="bg-gray-100 min-h-screen p-6">
    @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="alert alert-info mb-4">
            {{ session('info') }}
        </div>
    @endif
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Customers</h1>
        <x-button label="Create Customer" wire:click="create" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out" />
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <x-input placeholder="Search customers..." wire:model.debounce="search" class="w-64" />
                <div class="flex space-x-2">
                    <x-button icon="o-adjustments-horizontal" label="Filter" class="btn-outline-secondary" />
                    <x-button icon="o-arrows-up-down" label="Sort" class="btn-outline-secondary" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($customers as $customer)
                    <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition duration-300 ease-in-out">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold mr-3">
                                {{ strtoupper(substr($customer['name'], 0, 1)) }}
                            </div>
                            <div class="overflow-hidden">
                                <h3 class="text-base font-semibold text-gray-800 truncate">{{ $customer['name'] }}</h3>
                                <p class="text-sm text-gray-600 truncate">{{ $customer['email'] }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <x-button 
                                label="View details" 
                                wire:click="showCustomerDetails({{ $customer['id'] }})" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs py-1.5 px-2 rounded"
                            />
                            <x-button 
                                label="View Payment" 
                                wire:click="viewPayment({{ $customer['id'] }})" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white text-xs py-1.5 px-2 rounded"
                            />
                        </div>
                        <div class="flex justify-end space-x-2">
                            <x-button 
                                icon="o-pencil" 
                                wire:click="edit({{ $customer['id'] }})" 
                                class="btn-icon btn-xs bg-gray-200 hover:bg-gray-300 text-gray-600"
                            />
                            <x-button 
                                icon="o-trash" 
                                wire:click="delete({{ $customer['id'] }})" 
                                class="btn-icon btn-xs bg-red-200 hover:bg-red-300 text-red-600" 
                            />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-beige-50 px-6 py-4 border-t border-beige-200">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- Customer details modal -->
    <x-modal wire:model="customerDetailsOpen">
        <x-card title="Customer Details" class="bg-beige-800" class="text-beige-600">
            @if($selectedCustomer)
                <div class="space-y-4 text-beige-200">
                    <div><strong class="text-gray-100">Name:</strong> {{ $selectedCustomer['name'] }}</div>
                    <div><strong class="text-gray-100">Birthday:</strong> {{ $selectedCustomer['birthday'] }}</div>
                    <div><strong class="text-gray-100">Address:</strong> {{ $selectedCustomer['address'] }}</div>
                    <div><strong class="text-gray-100">Phone Number:</strong> {{ $selectedCustomer['phone_number'] }}</div>
                    <div><strong class="text-gray-100">Reference Contact Person:</strong> {{ $selectedCustomer['reference_contactperson'] ?? 'N/A' }}</div>
                    <div><strong class="text-gray-100">Reference Contact Person Phone:</strong> {{ $selectedCustomer['reference_contactperson_phonenumber'] ?? 'N/A' }}</div>
                    <div><strong class="text-gray-100">Email:</strong> {{ $selectedCustomer['email'] }}</div>
                    <div><strong class="text-gray-100">Valid ID:</strong> {{ $selectedCustomer['valid_id'] }}</div>
                    @if($selectedCustomer['valid_id_image'])
                        <div><strong class="text-gray-100">Valid ID Image:</strong> <img src="{{ Storage::url($selectedCustomer['valid_id_image']) }}" alt="Valid ID" class="max-w-xs mt-2"></div>
                    @endif
                </div>
            @endif
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button label="Close" wire:click="closeCustomerDetails" class="bg-beige-700 hover:bg-beige-600 text-beige-100" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <x-modal wire:model="modalOpen">
        <x-card title="{{ $customerId ? 'Edit Customer' : 'Create Customer' }}">
            <form wire:submit.prevent="store">
                <div class="space-y-4">
                    <x-input label="Name" wire:model="customer.name" />
                    <x-input label="Birthday" type="date" wire:model="customer.birthday" />
                    <x-input label="Address" wire:model="customer.address" />
                    <x-input label="Phone Number" wire:model="customer.phone_number" />
                    <x-input label="Reference Contact Person" wire:model="customer.reference_contactperson" />
                    <x-input label="Reference Contact Person Phone" wire:model="customer.reference_contactperson_phonenumber" />
                    <x-input label="Email" type="email" wire:model="customer.email" />
                    <x-input label="Valid ID" wire:model="customer.valid_id" />
                    <x-input label="Valid ID Image" type="file" wire:model="validIdImage" />
                </div>
                <div class="mt-4 flex justify-end">
                    <x-button type="button" wire:click="closeModal" class="mr-2">Cancel</x-button>
                    <x-button type="submit">Save</x-button>
                </div>
            </form>
        </x-card>
    </x-modal>

    <!-- Payment History Modal -->
    <x-modal wire:model="paymentHistoryOpen">
        <x-card title="Payment History" class="font-inter" class="text-beige-600">
            @if(count($selectedCustomerPayments) > 0)
                <div class="space-y-4">
                    @foreach($selectedCustomerPayments as $payment)
                        <div class="border-b pb-4">
                            <div class="text-lg font-medium text-gray-200 mb-2">
                                <span class="font-semibold">Date:</span> 
                                <span class="text-beige-600">{{ $payment['payment_date'] }}</span>
                            </div>
                            <div class="text-lg font-medium text-gray-200 mb-2">
                                <span class="font-semibold">Amount Paid:</span> 
                                <span class="text-beige-600">₱{{ number_format($payment['amount_paid'], 2) }}</span>
                            </div>
                            <div class="text-lg font-medium text-gray-200">
                                <span class="font-semibold">Due Amount:</span> 
                                <span class="text-beige-600">₱{{ number_format($payment['due_amount'], 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-lg">No payment history available for this customer.</p>
            @endif
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button label="Close" wire:click="closePaymentHistory" class="bg-gray-600 hover:bg-gray-700 text-beige" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
