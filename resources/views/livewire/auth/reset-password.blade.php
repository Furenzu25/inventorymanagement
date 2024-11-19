<div class="flex items-center justify-center min-h-screen p-6 bg-gradient-to-br from-[#401B1B] from-20% via-[#72383D] via-40% via-[#AB644B] via-60% via-[#9CABB4] via-80% to-[#F2F2EB]">
    <div class="w-full max-w-md">
        <div class="auth-card bg-white/90 backdrop-blur-sm shadow-lg rounded-lg overflow-hidden">
            <div class="p-8">
                <div class="mb-8 text-center">
                    <h2 class="company-name text-3xl font-bold mb-2">Reset Password</h2>
                    <p class="text-gray-600">Enter your new password</p>
                </div>

                <form wire:submit.prevent="resetPassword" class="space-y-6">
                    <div>
                        <x-input 
                            label="Email" 
                            wire:model.defer="email" 
                            type="email" 
                            placeholder="Enter your email"
                            class="w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                        />
                    </div>

                    <div>
                        <x-input 
                            label="New Password" 
                            wire:model.defer="password" 
                            type="password" 
                            placeholder="Enter new password"
                            class="w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                        />
                    </div>

                    <div>
                        <x-input 
                            label="Confirm New Password" 
                            wire:model.defer="password_confirmation" 
                            type="password" 
                            placeholder="Confirm new password"
                            class="w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                        />
                    </div>

                    <div>
                        <x-button 
                            type="submit" 
                            label="Reset Password" 
                            class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300 shadow-md"
                            spinner
                        />
                    </div>
                </form>
            </div>

            <div class="bg-[#F2F2EB]/50 px-8 py-4">
                <div class="text-center text-sm">
                    <a href="{{ route('login') }}" class="text-[#72383D] hover:text-[#401B1B] transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
