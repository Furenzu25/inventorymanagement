<div>
    {{-- Success is as dangerous as failure. --}}
    <x-modal wire:model="show" title="Edit Profile" separator>
        <form wire:submit.prevent="updateProfile">
            <div class="space-y-4">
                <x-input label="Name" wire:model="name" />
                <x-input label="Email" type="email" wire:model="email" />
            </div>
            <div class="mt-4 flex justify-end">
                <x-button type="submit" label="Update Profile" class="btn-primary" />
            </div>
        </form>
    </x-modal>
</div>
