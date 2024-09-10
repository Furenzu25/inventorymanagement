<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' | '.config('app.name') : config('app.name') }}</title>
    
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/TextPlugin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <style>
        .bg-gradient-animate {
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
        }
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="min-h-screen font-sans antialiased bg-gradient-animate bg-gradient-to-br from-red-900 via-black to-purple-900 text-gray-200">
    <div id="app-wrapper" class="relative min-h-screen overflow-hidden">
        {{-- NAVBAR --}}
        <x-nav sticky full-width class="bg-black/80 backdrop-blur-md border-b border-red-500/30 z-50">
            {{-- Brand --}}
            <x-slot:brand>
                <a href="/" wire:navigate class="flex items-center space-x-2 group">
                    <x-icon name="o-cube-transparent" class="w-12 h-12 text-red-500 group-hover:animate-spin transition-all duration-300" />
                    <span id="brandName" class="font-bold text-3xl text-red-500 font-['Orbitron'] group-hover:text-purple-400 transition-all duration-300">
                        Rosels Tech
                    </span>
                </a>
            </x-slot:brand>

            {{-- Right side actions --}}
            <x-slot:actions>
                <x-input placeholder="Search..." wire:model.debounce.500ms="search" class="bg-red-900/50 border-red-500/50 text-red-200 placeholder-red-400/70 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300" />
                <x-button label="Customers" icon="o-user" class="btn-ghost btn-sm text-red-300 hover:text-purple-300 hover:bg-purple-900/50 transition-all duration-300" link="{{ route('customers.index') }}" responsive />
                <x-button label="Products" icon="o-shopping-cart" class="btn-ghost btn-sm text-red-300 hover:text-purple-300 hover:bg-purple-900/50 transition-all duration-300" link="{{ route('products.index') }}" responsive />
                <x-button label="Pre-orders" icon="o-clipboard-document-list" class="btn-ghost btn-sm text-red-300 hover:text-purple-300 hover:bg-purple-900/50 transition-all duration-300" link="{{ route('preorders.index') }}" responsive />
            </x-slot:actions>
        </x-nav>

        {{-- MAIN --}}
        <x-main full-width class="p-4 sm:p-6 md:p-8">
            {{-- SIDEBAR --}}
            <x-slot:sidebar drawer="main-drawer" collapsible class="bg-black/50 backdrop-blur-md rounded-lg shadow-lg border border-red-500/30">
                {{-- MENU --}}
                <x-menu activate-by-route class="p-2">
                    {{-- User --}}
                    @if($user = auth()->user())
                        <x-menu-separator class="border-red-500/30" />

                        <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="rounded-lg bg-gradient-to-r from-red-900/50 to-purple-900/50 p-2 text-red-200">
                            <x-slot:actions>
                                <x-button icon="o-power" class="btn-circle btn-ghost btn-xs text-red-400 hover:text-purple-300 hover:bg-purple-700/50 transition-all duration-300" tooltip-left="Logout" no-wire-navigate link="/logout" />
                            </x-slot:actions>
                        </x-list-item>

                        <x-menu-separator class="border-red-500/30" />
                    @endif
                </x-menu>
            </x-slot:sidebar>

            {{-- The `$slot` goes here --}}
            <x-slot:content>
                <div class="bg-black/30 backdrop-blur-md rounded-lg shadow-lg p-6 border border-red-500/30 hover:border-purple-500/30 transition-all duration-300">
                    {{ $slot }}
                </div>
            </x-slot:content>
        </x-main>

        {{--  TOAST area --}}
        <x-toast />

        <div id="particles-js" class="fixed inset-0 pointer-events-none z-0"></div>

        {{-- Cyberpunk-style decorative elements --}}
        <div class="fixed top-0 left-0 w-1/4 h-1 bg-gradient-to-r from-red-500 to-purple-500"></div>
        <div class="fixed bottom-0 right-0 w-1/4 h-1 bg-gradient-to-l from-red-500 to-purple-500"></div>
        <div class="fixed top-0 right-0 w-1 h-1/4 bg-gradient-to-b from-red-500 to-purple-500"></div>
        <div class="fixed bottom-0 left-0 w-1 h-1/4 bg-gradient-to-t from-red-500 to-purple-500"></div>
    </div>

    <!-- Add this at the end of the body -->
    <div id="modal-container"></div>

    @livewireScripts
   

    @persist('animations')
    <script>
        // Function to initialize animations
        function initializeAnimations() {
            // Interactive elements
            const buttons = document.querySelectorAll('button, a');
            buttons.forEach(button => {
                button.addEventListener('mouseover', () => {
                    gsap.to(button, { y: -3, scale: 1.05, duration: 0.2, ease: 'power2.out' });
                });
                button.addEventListener('mouseout', () => {
                    gsap.to(button, { y: 0, scale: 1, duration: 0.2, ease: 'power2.out' });
                });
            });

            // Brand name effect
            const brandName = document.getElementById('brandName');
            if (brandName) {
                const originalText = brandName.textContent;
                
                brandName.addEventListener('mouseover', () => {
                    gsap.to(brandName, {
                        duration: 0.3,
                        text: {
                            value: "R0S3LS T3CH",
                            delimiter: ""
                        },
                        ease: "none"
                    });
                });

                brandName.addEventListener('mouseout', () => {
                    gsap.to(brandName, {
                        duration: 0.3,
                        text: {
                            value: originalText,
                            delimiter: ""
                        },
                        ease: "none"
                    });
                });
            }

            // Glitch effect on hover for content area
            const contentArea = document.querySelector('x-slot\\:content > div');
            if (contentArea) {
                contentArea.addEventListener('mouseover', () => {
                    gsap.to(contentArea, {
                        duration: 0.1,
                        x: () => Math.random() * 4 - 2,
                        y: () => Math.random() * 4 - 2,
                        repeat: 5,
                        yoyo: true,
                        ease: 'none'
                    });
                });
            }

            // Background animation is now handled by CSS
        }

        // Function to initialize particle effect
        function initializeParticles() {
            particlesJS('particles-js', {
                particles: {
                    number: { value: 60, density: { enable: true, value_area: 800 } },
                    color: { value: ['#ff0000', '#00ff00', '#0000ff'] },
                    shape: { type: 'circle' },
                    opacity: { value: 0.5, random: true, anim: { enable: true, speed: 1, opacity_min: 0.1, sync: false } },
                    size: { value: 3, random: true, anim: { enable: true, speed: 2, size_min: 0.1, sync: false } },
                    line_linked: { enable: true, distance: 150, color: '#ff00ff', opacity: 0.4, width: 1 },
                    move: { enable: true, speed: 2, direction: 'none', random: true, straight: false, out_mode: 'out', bounce: false }
                },
                interactivity: {
                    detect_on: 'canvas',
                    events: { onhover: { enable: true, mode: 'repulse' }, onclick: { enable: true, mode: 'push' }, resize: true },
                    modes: { repulse: { distance: 100, duration: 0.4 }, push: { particles_nb: 4 } }
                },
                retina_detect: true
            });
        }

        // Initialize animations and particles
        initializeAnimations();
        initializeParticles();

        // Reinitialize animations on Livewire updates
        document.addEventListener('livewire:navigated', initializeAnimations);
        document.addEventListener('livewire:update', initializeAnimations);
    </script>
    @endpersist
</body>
</html>