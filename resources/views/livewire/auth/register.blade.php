<div class="flex items-center justify-center min-h-screen p-6 bg-gradient-to-br from-[#401B1B] via-[#72383D] via-[#AB644B] via-[#9CABB4] via-[#D2DCE6] to-[#F2F2EB]">
    <div class="w-full max-w-md">
        <div class="auth-card bg-white/90 backdrop-blur-sm shadow-lg rounded-lg overflow-hidden">
            <div class="p-8">
                <div class="mb-8 text-center">
                    <h2 class="company-name text-3xl font-bold mb-2">Rosels Trading</h2>
                    <p class="text-[#72383D]">Create your account</p>
                </div>

                <form wire:submit.prevent="register" class="space-y-6">
                    <div>
                        <x-input 
                            label="Name" 
                            wire:model.defer="name" 
                            type="text" 
                            placeholder="Enter your name"
                            class="w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                        />
                        @error('name') 
                            <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input 
                            label="Email" 
                            wire:model.defer="email" 
                            type="email" 
                            placeholder="Enter your email"
                            class="w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                        />
                        @error('email') 
                            <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input 
                            label="Password" 
                            wire:model.defer="password" 
                            type="password" 
                            placeholder="Enter your password"
                            class="w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                        />
                        @error('password') 
                            <span class="text-[#AB644B] text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input 
                            label="Confirm Password" 
                            wire:model.defer="password_confirmation" 
                            type="password" 
                            placeholder="Confirm your password"
                            class="w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                        />
                    </div>

                    <div>
                        <x-button 
                            type="submit" 
                            label="Register" 
                            class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300 shadow-md"
                            spinner
                        />
                    </div>
                </form>
            </div>

            <div class="bg-[#F2F2EB]/50 px-8 py-4">
                <div class="text-center text-sm">
                    <a href="{{ route('login') }}" class="text-[#72383D] hover:text-[#401B1B] transition-colors">
                        <i class="fas fa-sign-in-alt mr-1"></i> Already have an account? Sign in
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
