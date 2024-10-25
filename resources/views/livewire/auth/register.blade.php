<div class="flex items-center justify-center min-h-screen bg-gradient-animate bg-gradient-to-br from-red-900 via-black to-purple-900">
    <div class="w-full max-w-md">
        <x-card class="bg-black/30 backdrop-blur-md border border-red-500/30">
            <h2 class="text-2xl font-bold text-center text-red-500 mb-6">Register</h2>
            <form wire:submit.prevent="register">
                <div class="space-y-4">
                    <x-input 
                        label="Name" 
                        wire:model.defer="name" 
                        type="text" 
                        placeholder="Enter your name"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Email" 
                        wire:model.defer="email" 
                        type="email" 
                        placeholder="Enter your email"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Password" 
                        wire:model.defer="password" 
                        type="password" 
                        placeholder="Enter your password"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Confirm Password" 
                        wire:model.defer="password_confirmation" 
                        type="password" 
                        placeholder="Confirm your password"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Birthday" 
                        wire:model.defer="birthday" 
                        type="date" 
                        class="bg-gray-800 text-white"
                    />
                    <x-textarea 
                        label="Address" 
                        wire:model.defer="address" 
                        placeholder="Enter your address"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Phone Number" 
                        wire:model.defer="phone_number" 
                        type="text" 
                        placeholder="Enter your phone number"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Reference Contact Person" 
                        wire:model.defer="reference_contactperson" 
                        type="text" 
                        placeholder="Enter reference contact person"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Reference Contact Person Phone Number" 
                        wire:model.defer="reference_contactperson_phonenumber" 
                        type="text" 
                        placeholder="Enter reference contact person phone number"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Valid ID Number" 
                        wire:model.defer="valid_id" 
                        type="text" 
                        placeholder="Enter your valid ID number"
                        class="bg-gray-800 text-white"
                    />
                    <x-input 
                        label="Valid ID Image" 
                        wire:model="valid_id_image" 
                        type="file" 
                        class="bg-gray-800 text-white"
                    />
                </div>
                <div class="mt-6">
                    <x-button 
                        type="submit" 
                        label="Register" 
                        class="w-full btn-outline text-red-500"
                        spinner
                    />
                </div>
            </form>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-red-500 hover:text-red-400">Already have an account? Login</a>
            </div>
        </x-card>
    </div>
</div>
