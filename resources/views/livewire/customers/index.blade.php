<div>
    <!-- HEADER -->
    <x-header title="Customers">
        <x-slot:actions>
            <x-button label="Create Customer" wire:click="create" />
            <x-input placeholder="Search..." wire:model.debounce="search" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE -->
    <x-card>
        <x-table>
            <x-slot:headers>
                <x-table.header>Name</x-table.header>
                <x-table.header>Age</x-table.header>
                <x-table.header>Address</x-table.header>
                <x-table.header>Phone Number</x-table.header>
                <x-table.header>Email</x-table.header>
                <x-table.header>Valid ID</x-table.header>
                <x-table.header>Actions</x-table.header>
            </x-slot:headers>
            <x-slot:rows>
                @foreach ($customers as $customer)
                    <x-table.row>
                        <x-table.cell>{{ $customer->name }}</x-table.cell>
                        <x-table.cell>{{ $customer->age }}</x-table.cell>
                        <x-table.cell>{{ $customer->address }}</x-table.cell>
                        <x-table.cell>{{ $customer->phone_number }}</x-table.cell>
                        <x-table.cell>{{ $customer->email }}</x-table.cell>
                        <x-table.cell>{{ $customer->valid_id }}</x-table.cell>
                        <x-table.cell>
                            <x-button label="Edit" wire:click="edit({{ $customer->id }})" />
                            <x-button label="Delete" wire:click="delete({{ $customer->id }})" />
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot:rows>
        </x-table>
    </x-card>

    <!-- Modal for creating/editing customers -->
    <x-modal wire:model.defer="modalOpen">
        <x-slot:title>
            {{ $customer->id ? 'Edit Customer' : 'Create Customer' }}
        </x-slot:title>
        <form wire:submit.prevent="store">
            <x-input label="Name" wire:model.defer="customer.name" />
            <x-input label="Age" type="number" wire:model.defer="customer.age" />
            <x-input label="Address" wire:model.defer="customer.address" />
            <x-input label="Phone Number" wire:model.defer="customer.phone_number" />
            <x-input label="Email" type="email" wire:model.defer="customer.email" />
            <x-input label="Valid ID" wire:model.defer="customer.valid_id" />
            <x-button type="submit" label="Save" />
        </form>
    </x-modal>
</div>
