<div class="flex items-center justify-center min-h-screen bg-gradient-animate bg-gradient-to-br from-red-900 via-black to-purple-900">
    <div class="w-full max-w-md">
        <x-card class="bg-black/30 backdrop-blur-md border border-red-500/30">
            <h2 class="text-2xl font-bold text-center text-red-500 mb-6">Login</h2>
            <form wire:submit.prevent="login">
                <div class="space-y-4">
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
                </div>
                <div class="mt-6">
                    <x-button 
                        type="submit" 
                        label="Login" 
                        class="w-full btn-outline text-red-500"
                        spinner
                    />
                </div>
            </form>
        </x-card>
    </div>
</div>
