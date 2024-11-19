<div class="flex items-center justify-center min-h-screen p-6 bg-gradient-to-br from-[#401B1B] from-20% via-[#72383D] via-40% via-[#AB644B] via-60% via-[#9CABB4] via-80% to-[#F2F2EB]">
    <div class="w-full max-w-md">
        <div class="auth-card bg-white/90 backdrop-blur-sm shadow-lg rounded-lg overflow-hidden">
            <div class="p-8">
                <div class="mb-8 text-center">
                    <h2 class="company-name text-3xl font-bold mb-2">Rosels Trading</h2>
                   
                </div>

                @if ($message)
                    <div class="mb-4 p-3 bg-[#72383D]/10 text-[#72383D] rounded-lg">
                        {{ $message }}
                    </div>
                @endif

                @if ($loginError)
                    <div class="mb-4 p-3 bg-[#AB644B]/10 text-[#AB644B] rounded-lg">
                        {{ $loginError }}
                    </div>
                @endif

                @if ($status)
                    <div class="mb-4 p-3 bg-[#72383D]/10 text-[#72383D] rounded-lg">
                        {{ $status }}
                    </div>
                @endif

                <form wire:submit.prevent="login" class="space-y-6">
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
                            label="Password" 
                            wire:model.defer="password" 
                            type="password" 
                            placeholder="Enter your password"
                            class="w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                        />
                    </div>

                    <div>
                        <x-button 
                            type="submit" 
                            label="Login" 
                            class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300 shadow-md"
                            spinner
                        />
                    </div>
                </form>
            </div>

            <div class="bg-[#F2F2EB]/50 px-8 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
                    <a href="{{ route('register') }}" class="text-[#72383D] hover:text-[#401B1B] transition-colors">
                        <i class="fas fa-user-plus mr-1"></i> Create an account
                    </a>
                    <a href="{{ route('password.request') }}" class="text-[#72383D] hover:text-[#401B1B] transition-colors">
                        <i class="fas fa-key mr-1"></i> Forgot password?
                    </a>
                </div>
                <div class="text-center mt-4 text-sm">
                    <a href="{{ route('landing') }}" class="text-[#72383D] hover:text-[#401B1B] transition-colors">
                        <i class="fas fa-home mr-1"></i> Back to Landing Page
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
