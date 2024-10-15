<x-layouts.guest>
    <div class="flex items-center justify-center min-h-screen bg-gradient-animate bg-gradient-to-br from-red-900 via-black to-purple-900">
        <div class="w-full max-w-md">
            <x-card class="bg-black/30 backdrop-blur-md border border-red-500/30 hover:border-purple-500/30 transition-all duration-300">
                <h2 class="text-2xl font-bold text-center text-red-500 mb-6 font-['Orbitron']">Verify Your Email</h2>
                
                @if (session('resent'))
                    <div class="mb-4 font-medium text-sm text-green-400">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div class="mb-4 text-sm text-gray-400">
                    {{ __('Before proceeding, please check your email for a verification link. If you did not receive the email, click below to request another.') }}
                </div>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <x-button type="submit" class="w-full btn-outline text-red-500 hover:bg-red-500 hover:text-black transition-all duration-300">
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </form>
            </x-card>
        </div>
    </div>

    <div id="particles-js" class="fixed inset-0 pointer-events-none z-0"></div>

    {{-- Cyberpunk-style decorative elements --}}
    <div class="fixed top-0 left-0 w-1/4 h-1 bg-gradient-to-r from-red-500 to-purple-500"></div>
    <div class="fixed bottom-0 right-0 w-1/4 h-1 bg-gradient-to-l from-red-500 to-purple-500"></div>
    <div class="fixed top-0 right-0 w-1 h-1/4 bg-gradient-to-b from-red-500 to-purple-500"></div>
    <div class="fixed bottom-0 left-0 w-1 h-1/4 bg-gradient-to-t from-red-500 to-purple-500"></div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                particles: {
                    number: { value: 80, density: { enable: true, value_area: 800 } },
                    color: { value: "#ffffff" },
                    shape: { type: "circle" },
                    opacity: { value: 0.5, random: true },
                    size: { value: 3, random: true },
                    line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                    move: { enable: true, speed: 6, direction: "none", random: false, straight: false, out_mode: "out", bounce: false }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" }, resize: true },
                    modes: { repulse: { distance: 100, duration: 0.4 }, push: { particles_nb: 4 } }
                },
                retina_detect: true
            });
        });
    </script>
    @endpush
</x-layouts.guest>
