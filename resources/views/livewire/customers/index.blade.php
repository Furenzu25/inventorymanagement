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
        <x-table :headers="$headers" :rows="$customers" :sort-by="$sortBy">
            @scope('actions', $customer)
                <div class="flex justify-start gap-2 w-40">
                    <x-button icon="o-pencil" wire:click="edit({{ $customer['id'] }})" label="Edit" class="btn-primary btn-sm" />
                    <x-button icon="o-trash" wire:click="delete({{ $customer['id'] }})" wire:confirm="Are you sure you want to delete this customer?" spinner class="btn-ghost btn-sm text-red-500" />
                </div>
            @endscope

            @scope('cell_valid_id_image', $customer)
                @if($customer['valid_id_image'])
                    <div class="relative group cursor-pointer" wire:click="showExpandedImage('{{ $customer['valid_id_image'] }}')">
                        <img src="{{ Storage::url($customer['valid_id_image']) }}" 
                             alt="Valid ID" 
                             class="w-16 h-16 object-cover transition-transform duration-300 ease-in-out transform group-hover:scale-105"
                        >
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 text-white text-sm">
                            Click to expand
                        </div>
                    </div>
                @else
                    <span class="text-gray-500">No image</span>
                @endif
            @endscope

            @scope('cell_created_at', $customer)
                {{ \Carbon\Carbon::parse($customer['created_at'])->format('Y-m-d') }}
            @endscope
        </x-table>
        {{ $customers->links() }} <!-- Pagination links -->
    </x-card>

    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button>
        <x-input placeholder="Search..." wire:model.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>

    @teleport('body')
        <x-modal wire:model="modalOpen" title="{{ $customerId ? 'Edit Customer' : 'Create Customer' }}" separator class="bg-black/30 backdrop-blur-md border border-red-500/30">
            <form wire:submit.prevent="store">
                <div class="space-y-4">
                    <x-input label="Name" wire:model="customer.name" class="mb-0.5" />
                    <x-input label="Birthday" wire:model="customer.birthday" type="date" class="mb-0.5" />
                    <x-textarea label="Address" wire:model="customer.address" rows="3" class="mb-0.5" />
                    <x-input label="Phone Number" wire:model="customer.phone_number" class="mb-0.5" />
                    <x-textarea label="Reference Contact Person" wire:model="customer.reference_contactperson" rows="2" class="mb-0.5" />
                    <x-input label="Reference Contact Number" wire:model="customer.reference_contactperson_phonenumber" class="mb-0.5" />
                    <x-input label="Email" type="email" wire:model="customer.email" class="mb-0.5" />
                    <x-input label="Valid ID Number" wire:model="customer.valid_id" class="mb-0.5" />
                    <div>
                        <x-file wire:model="validIdImage" label="Valid ID Image" hint="Max 5MB" accept="image/*" class="mb-0.5" />
                        @if($imageUploaded)
                            <p class="text-sm text-green-500 mt-1">Image Uploaded</p>
                        @endif
                    </div>
                    
                    @if ($customerId)
                        <!-- Reason for editing -->
                        <x-textarea label="Reason for Edit" wire:model.defer="editReason" rows="2" class="mb-0.5" />
                    @endif
                </div>
                
                <div class="flex justify-end gap-x-4 mt-4">
                    <x-button label="Cancel" class="btn-outline text-blue-500" @click="$wire.modalOpen = false" />
                    <x-button label="Save" type="submit" class="btn-outline text-red-500" wire:loading.attr="disabled" />
                </div>
            </form>
        </x-modal>
    @endteleport

    @if($selectedImage)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeExpandedImage">
            <div class="bg-white p-4 rounded-lg max-w-3xl max-h-3xl">
                <img src="{{ Storage::url($selectedImage) }}" alt="Expanded Valid ID" class="max-w-full max-h-full object-contain">
            </div>
        </div>
    @endif
</div>
