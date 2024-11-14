<div>
    <x-modal wire:model="showModal">
        <x-card title="Edit Profile">
            <form wire:submit.prevent="updateProfile">
                <div class="space-y-4">
                    <x-input label="Name" wire:model="name" />
                    <x-input label="Email" type="email" wire:model="email" />
                </div>
                <div class="mt-4 flex justify-end">
                    <x-button type="button" wire:click="$set('showModal', false)" class="mr-2">Cancel</x-button>
                    <x-button type="submit" class="bg-blue-500">Save Changes</x-button>
                </div>
            </form>
        </x-card>
    </x-modal>
</div>
