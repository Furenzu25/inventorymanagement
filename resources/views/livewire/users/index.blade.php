<div>
    <!-- HEADER -->
    <x-header title="Customers">
        <x-slot:actions>
            <x-button label="Create Customer" wire:click="create" />
            <x-input placeholder="Search..." wire:model.debounce="search" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$customers" :sort-by="$sortBy">
            @scope('actions', $customer)
                <x-button icon="o-pencil" wire:click="edit({{ $customer['id'] }})" label="Edit" class="btn-primary" />
                <x-button icon="o-trash" wire:click="delete({{ $customer['id'] }})" wire:confirm="Are you sure?" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
        {{ $customers->links() }} <!-- Pagination links -->
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>

    <!-- Modal for creating/editing customers -->
    <x-modal wire:model.defer="modalOpen">
        <x-slot:title>
            {{ $customerId ? 'Edit Customer' : 'Create Customer' }}
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
