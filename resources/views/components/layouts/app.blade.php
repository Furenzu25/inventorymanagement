<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' | '.config('app.name') : config('app.name') }}</title>
    
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles and scripts -->
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

        /* Sidebar Styling */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            z-index: 100;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Align to top */
            transition: transform 0.3s ease;
            gap: 20px; /* Increased gap between buttons */
        }

        #sidebar.hidden {
            transform: translateX(-250px); /* Hide sidebar */
        }

        /* Sidebar button styling */
        .sidebar-button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px;
            background-color: #1a1a1a;
            color: white;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .sidebar-button:hover {
            background-color: #4a4a4a;
        }

        /* Sidebar Toggle Icon */
        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px; /* Ensure the toggle stays visible */
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.85);
            color: white;
            border-radius: 50%;
            cursor: pointer;
            z-index: 101; /* Ensure it's above other elements */
        }

        .sidebar-toggle img {
            width: 24px;
            height: 24px;
        }

        /* Main content */
        .main-content {
            margin-left: 250px; /* Ensure the content starts after the sidebar */
            transition: margin-left 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: 0; /* Collapsed view */
        }

        /* Added margin for first sidebar button (Dashboard) */
        .sidebar-button:first-child {
            margin-top: 50px; /* Adjust to move the Dashboard lower */
        }
    </style>
</head>

<body class="min-h-screen font-sans antialiased bg-gradient-animate bg-gradient-to-br from-red-900 via-black to-purple-900 text-gray-200">
    <div id="app-wrapper" class="relative min-h-screen overflow-hidden">
        
        {{-- SIDEBAR --}}
        <div id="sidebar">
            {{-- Sidebar buttons --}}
            <a href="/" class="sidebar-button">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('customers.index') }}" class="sidebar-button">
                <i class="fas fa-users"></i> Customers
            </a>
            <a href="{{ route('products.index') }}" class="sidebar-button">
                <i class="fas fa-box"></i> Products
            </a>
            <a href="{{ route('preorders.index') }}" class="sidebar-button">
                <i class="fas fa-clipboard-list"></i> Pre-orders
            </a>
            <a href="{{ route('sales.index') }}" class="sidebar-button">
                <i class="fas fa-dollar-sign"></i> Sales
            </a>
            <a href="{{ route('payments.index') }}" class="sidebar-button">
                <i class="fas fa-money-bill-wave"></i> Payments
            </a>
            <a href="{{ route('payments.history', ['sale' => 'all']) }}" class="sidebar-button">
                <i class="fas fa-history"></i> Payment History
            </a>
        </div>

        {{-- Sidebar Toggle Button (Visible always) --}}
        <button id="toggleSidebar" class="sidebar-toggle">
            <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>

        {{-- MAIN CONTENT --}}
        <div id="mainContent" class="main-content">
            <x-nav sticky full-width class="bg-black/80 backdrop-blur-md border-b border-red-500/30 z-50">
                <x-slot:brand>
                    <a href="/" wire:navigate class="flex items-center space-x-2 group">
                        <x-icon name="o-cube-transparent" class="w-12 h-12 text-red-500 group-hover:animate-spin transition-all duration-300" />
                        <span id="brandName" class="font-bold text-3xl text-red-500 font-['Orbitron'] group-hover:text-purple-400 transition-all duration-300">
                            Rosels Trading
                        </span>
                    </a>
                </x-slot:brand>
            </x-nav>

            <x-main full-width class="p-4 sm:p-6 md:p-8">
                <x-slot:content>
                    <div class="bg-black/30 backdrop-blur-md rounded-lg shadow-lg p-6 border border-red-500/30 hover:border-purple-500/30 transition-all duration-300">
                        {{ $slot }}
                    </div>
                </x-slot:content>
            </x-main>

            <x-toast />
        </div>

        <div id="particles-js" class="fixed inset-0 pointer-events-none z-0"></div>

        {{-- Cyberpunk-style decorative elements --}}
        <div class="fixed top-0 left-0 w-1/4 h-1 bg-gradient-to-r from-red-500 to-purple-500"></div>
        <div class="fixed bottom-0 right-0 w-1/4 h-1 bg-gradient-to-l from-red-500 to-purple-500"></div>
        <div class="fixed top-0 right-0 w-1 h-1/4 bg-gradient-to-b from-red-500 to-purple-500"></div>
        <div class="fixed bottom-0 left-0 w-1 h-1/4 bg-gradient-to-t from-red-500 to-purple-500"></div>
    </div>

    <div id="modal-container"></div>

    @livewireScripts

    @persist('animations')
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('collapsed');
        });

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
                            value: "R0S3LS TR4DING",
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
        }

        initializeAnimations();
    </script>
    @endpersist
</body>
</html>
