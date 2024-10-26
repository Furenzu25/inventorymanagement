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
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 ease-in-out">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                {{ strtoupper(substr($customer['name'], 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $customer['name'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $customer['email'] }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <x-button 
                                label="View details" 
                                wire:click="showCustomerDetails({{ $customer['id'] }})" 
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-full transition duration-300 ease-in-out"
                            />
                            <x-button 
                                label="View Payment" 
                                wire:click="viewPayment({{ $customer['id'] }})" 
                                class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-2 px-4 rounded-full transition duration-300 ease-in-out"
                            />
                            <div class="flex space-x-2">
                                <x-button 
                                    icon="o-pencil" 
                                    wire:click="edit({{ $customer['id'] }})" 
                                    class="btn-icon btn-sm bg-gray-200 hover:bg-gray-300 text-gray-600"
                                />
                                <x-button icon="o-trash" wire:click="delete({{ $customer['id'] }})" class="btn-icon btn-sm bg-red-200 hover:bg-red-300 text-red-600" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- Customer details modal -->
    <x-modal wire:model="customerDetailsOpen">
        <x-card title="Customer Details">
            @if($selectedCustomer)
                <div class="space-y-4">
                    <div><strong>Name:</strong> {{ $selectedCustomer['name'] }}</div>
                    <div><strong>Birthday:</strong> {{ $selectedCustomer['birthday'] }}</div>
                    <div><strong>Address:</strong> {{ $selectedCustomer['address'] }}</div>
                    <div><strong>Phone Number:</strong> {{ $selectedCustomer['phone_number'] }}</div>
                    <div><strong>Reference Contact Person:</strong> {{ $selectedCustomer['reference_contactperson'] ?? 'N/A' }}</div>
                    <div><strong>Reference Contact Person Phone:</strong> {{ $selectedCustomer['reference_contactperson_phonenumber'] ?? 'N/A' }}</div>
                    <div><strong>Email:</strong> {{ $selectedCustomer['email'] }}</div>
                    <div><strong>Valid ID:</strong> {{ $selectedCustomer['valid_id'] }}</div>
                    @if($selectedCustomer['valid_id_image'])
                        <div><strong>Valid ID Image:</strong> <img src="{{ Storage::url($selectedCustomer['valid_id_image']) }}" alt="Valid ID" class="max-w-xs mt-2"></div>
                    @endif
                </div>
            @endif
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button label="Close" wire:click="closeCustomerDetails" />
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
        <x-card title="Payment History">
            @if(count($selectedCustomerPayments) > 0)
                <div class="space-y-4">
                    @foreach($selectedCustomerPayments as $payment)
                        <div class="border-b pb-2">
                            <div><strong>Date:</strong> {{ $payment['payment_date'] }}</div>
                            <div><strong>Amount Paid:</strong> ${{ number_format($payment['amount_paid'], 2) }}</div>
                            <div><strong>Due Amount:</strong> ${{ number_format($payment['due_amount'], 2) }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No payment history available for this customer.</p>
            @endif
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button label="Close" wire:click="closePaymentHistory" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
