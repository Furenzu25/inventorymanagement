<div>
    <x-modal wire:model="showModal">
        <x-card title="Complete Your Profile">
            <form wire:submit="save">
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
                <div class="mt-4 flex justify-end space-x-2">
                    <x-button label="Cancel" wire:click="close" />
                    <x-button label="Save" type="submit" primary />
                </div>
            </form>
        </x-card>
    </x-modal>
</div> 