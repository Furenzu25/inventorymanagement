<div>
    <x-modal wire:model="showModal">
        <x-card title="Complete Your Profile">
            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    Complete your profile to unlock all features including pre-ordering products.
                    You can skip this step, but you won't be able to place pre-orders until your profile is complete.
                </p>
            </div>
            
            <form wire:submit.prevent="completeProfile">
                <div class="space-y-4">
                    <x-input 
                        label="Birthday" 
                        wire:model="birthday" 
                        type="date"
                    />
                    <x-textarea 
                        label="Address" 
                        wire:model="address" 
                        placeholder="Enter your complete address"
                    />
                    <x-input 
                        label="Phone Number" 
                        wire:model="phone_number" 
                        type="text" 
                        placeholder="Enter your phone number"
                    />
                    <x-input 
                        label="Reference Contact Person" 
                        wire:model="reference_contactperson" 
                        type="text" 
                        placeholder="Enter reference contact person"
                    />
                    <x-input 
                        label="Reference Contact Phone" 
                        wire:model="reference_contactperson_phonenumber" 
                        type="text" 
                        placeholder="Enter reference contact phone"
                    />
                    <x-input 
                        label="Valid ID Number" 
                        wire:model="valid_id" 
                        type="text" 
                        placeholder="Enter your valid ID number"
                    />
                    <x-input 
                        label="Valid ID Image" 
                        wire:model="valid_id_image" 
                        type="file" 
                    />
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <x-button 
                        type="button" 
                        wire:click="skip" 
                        class="bg-gray-500"
                        label="Skip for Now"
                    />
                    <x-button 
                        type="submit" 
                        class="bg-blue-500"
                        label="Complete Profile"
                    />
                </div>
            </form>
        </x-card>
    </x-modal>
</div> 