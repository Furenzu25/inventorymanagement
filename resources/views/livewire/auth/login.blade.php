<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-[#2c3e50] via-[#3498db] to-[#2ecc71]">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-2xl rounded-lg overflow-hidden">
            <div class="p-4 sm:p-6 md:p-8">
                <div class="mb-6 text-center">
                    <svg class="mx-auto h-12 w-auto mb-4 text-[#3498db]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 16V8.00002C20.9996 7.6493 20.9071 7.30483 20.7315 7.00119C20.556 6.69754 20.3037 6.44539 20 6.27002L13 2.27002C12.696 2.09449 12.3511 2.00208 12 2.00208C11.6489 2.00208 11.304 2.09449 11 2.27002L4 6.27002C3.69626 6.44539 3.44398 6.69754 3.26846 7.00119C3.09294 7.30483 3.00036 7.6493 3 8.00002V16C3.00036 16.3508 3.09294 16.6952 3.26846 16.9989C3.44398 17.3025 3.69626 17.5547 4 17.73L11 21.73C11.304 21.9056 11.6489 21.998 12 21.998C12.3511 21.998 12.696 21.9056 13 21.73L20 17.73C20.3037 17.5547 20.556 17.3025 20.7315 16.9989C20.9071 16.6952 20.9996 16.3508 21 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h2 class="text-3xl font-bold tracking-tight" style="background: linear-gradient(45deg, #3498db, #2ecc71); -webkit-background-clip: text; background-clip: text; color: transparent;">Welcome to Rosels Trading</h2>
                    <p class="text-gray-600 mt-2 text-[17px]">Please sign in to your account</p>
                </div>
                @if ($message)
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $message }}
                    </div>
                @endif
                @if ($loginError)
                    <div class="mb-4 font-medium text-sm text-red-500">
                        {{ $loginError }}
                    </div>
                @endif
                @if ($status)
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $status }}
                    </div>
                @endif
                <form wire:submit.prevent="login">
                    <div class="space-y-4">
                        <x-input 
                            label="Email" 
                            wire:model.defer="email" 
                            type="email" 
                            placeholder="Enter your email"
                            class="text-[17px]"
                        />
                        <x-input 
                            label="Password" 
                            wire:model.defer="password" 
                            type="password" 
                            placeholder="Enter your password"
                            class="text-[17px]"
                        />
                    </div>
                    <div class="mt-6">
                        <x-button 
                            type="submit" 
                            label="Login" 
                            class="w-full bg-[#3498db] hover:bg-[#2980b9] text-white text-[17px] font-semibold"
                            spinner
                        />
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 text-center">
                <p class="text-[15px] text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-[#3498db] hover:text-[#2980b9]">Create an account</a>
                </p>
            </div>
            <div class="mt-4 text-center pb-6">
                <span class="mx-2 text-[15px]">|</span>
                <a href="{{ route('password.request') }}" class="text-[15px] text-[#3498db] hover:text-[#2980b9]">Forgot your password?</a>
            </div>
        </div>
    </div>
</div>
