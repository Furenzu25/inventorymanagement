<div>
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
    
    <x-header title="Customers">
        <x-slot:actions>
            <x-button label="Create Customer" wire:click="create" class="btn-outline text-red-500" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($customers as $customer)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-yellow-200 rounded-full flex items-center justify-center text-yellow-600 text-2xl font-bold mr-4">
                            {{ strtoupper(substr($customer['name'], 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">{{ $customer['name'] }}</h3>
                            <x-button 
                                label="View details" 
                                wire:click="showCustomerDetails({{ $customer['id'] }})" 
                                class="btn-sm mt-2 bg-yellow-500 hover:bg-yellow-600 text-white"
                            />
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <x-button icon="o-pencil" wire:click="edit({{ $customer['id'] }})" label="Edit" class="btn-primary btn-sm" />
                        <x-button icon="o-trash" wire:click="delete({{ $customer['id'] }})" wire:confirm="Are you sure you want to delete this customer?" spinner class="btn-ghost btn-sm text-red-500" />
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $customers->links() }}
        </div>
    </x-card>

    @if($selectedImage)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeExpandedImage">
            <div class="bg-white p-4 rounded-lg max-w-3xl max-h-3xl">
                <img src="{{ $selectedImage }}" alt="Expanded Valid ID" class="max-w-full max-h-full object-contain">
            </div>
        </div>
    @endif

    <x-modal wire:model="customerDetailsOpen">
        <x-slot:title>
            {{ $selectedCustomer['name'] ?? '' }}'s Details
        </x-slot:title>
        <div class="space-y-2 text-gray-300">
            @if($selectedCustomer)
                <p><strong>Birthday:</strong> {{ $selectedCustomer['birthday'] }}</p>
                <p><strong>Address:</strong> {{ $selectedCustomer['address'] }}</p>
                <p><strong>Phone:</strong> {{ $selectedCustomer['phone_number'] }}</p>
                <p><strong>Email:</strong> {{ $selectedCustomer['email'] }}</p>
                <p><strong>Reference Contact:</strong> {{ $selectedCustomer['reference_contactperson'] }}</p>
                <p><strong>Reference Phone:</strong> {{ $selectedCustomer['reference_contactperson_phonenumber'] }}</p>
                <p><strong>Valid ID:</strong> {{ $selectedCustomer['valid_id'] }}</p>
                @if($selectedCustomer['valid_id_image'])
                    <div class="mt-4">
                        <strong>Valid ID Image:</strong>
                        <img src="{{ Storage::url($selectedCustomer['valid_id_image']) }}" alt="Valid ID" class="mt-2 max-w-full h-auto">
                    </div>
                @endif
            @endif
        </div>
        <x-slot:footer>
            <x-button label="Close" wire:click="closeCustomerDetails" />
        </x-slot:footer>
    </x-modal>
</div>
