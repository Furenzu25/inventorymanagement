<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' | '.config('app.name') : config('app.name') }}</title>
    
    @livewireStyles
    
    <!-- Inline critical CSS to ensure styling works -->
    <style>
        @tailwind base;
        @tailwind components;
        @tailwind utilities;
        
        :root {
            --color-primary: #401B1B;
            --color-secondary: #72383D;
            --color-tertiary: #AB644B;
            --color-quaternary: #9CABB4;
            --color-quinary: #D2DCE6;
            --color-senary: #F2F2EB;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, var(--color-senary), var(--color-quinary));
        }

        #sidebar {
            background: linear-gradient(to bottom, var(--color-primary), var(--color-secondary));
        }

        .sidebar-button {
            transition: background-color 0.3s ease;
        }

        .sidebar-button:hover, .sidebar-button.active {
            background-color: var(--color-tertiary);
            opacity: 0.8;
        }

        .company-name {
            background: linear-gradient(45deg, var(--color-quinary), var(--color-senary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .top-bar {
            background: linear-gradient(to right, var(--color-quinary), var(--color-senary));
        }

        .content-card {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Add core tailwind utility classes */
        .flex { display: flex; }
        .flex-1 { flex: 1 1 0%; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .relative { position: relative; }
        .fixed { position: fixed; }
        .absolute { position: absolute; }
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        .min-h-screen { min-height: 100vh; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .m-6 { margin: 1.5rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .ml-64 { margin-left: 16rem; }
        .mr-2 { margin-right: 0.5rem; }
        .mt-8 { margin-top: 2rem; }
        .space-y-2 > :not([hidden]) ~ :not([hidden]) { margin-top: 0.5rem; }
        .space-x-4 > :not([hidden]) ~ :not([hidden]) { margin-left: 1rem; }
        .rounded { border-radius: 0.25rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-full { border-radius: 9999px; }
        .bg-white { background-color: white; }
        .text-white { color: white; }
        .text-center { text-align: center; }
        .font-bold { font-weight: 700; }
        .text-2xl { font-size: 1.5rem; }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .w-64 { width: 16rem; }
        .z-40 { z-index: 40; }
        .z-50 { z-index: 50; }
        .transition-all { transition-property: all; }
        .transition-transform { transition-property: transform; }
        .duration-300 { transition-duration: 300ms; }
        .transform { transform: translateX(0); }
        .bottom-0 { bottom: 0; }
        .bottom-6 { bottom: 1.5rem; }
        .right-6 { right: 1.5rem; }
        .block { display: block; }
        .hover\:bg-opacity-80:hover { opacity: 0.8; }
    </style>

    <!-- Safely include Vite generated assets if possible -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Tailwind CDN as additional fallback -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6]">
    <div id="app-wrapper" class="relative min-h-screen flex">
        
        {{-- SIDEBAR --}}
        <div id="sidebar" class="w-64 fixed top-0 left-0 h-full z-40 transition-transform duration-300 ease-in-out transform">
            <div class="p-6">
                <h1 class="company-name text-2xl font-bold mb-6 text-center">Rosels Trading</h1>
                {{-- Sidebar buttons --}}
                <nav class="space-y-2">
                    <a href="/dashboard" 
                       class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80 {{ request()->is('dashboard*') ? 'bg-[#AB644B]' : '' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="{{ route('inventory.index') }}" 
                       class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80 {{ request()->routeIs('inventory.*') ? 'bg-[#AB644B]' : '' }}">
                        <i class="fas fa-box mr-2"></i> Inventory
                    </a>    
                    <a href="{{ route('customers.index') }}" 
                       class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80 {{ request()->routeIs('customers.*') ? 'bg-[#AB644B]' : '' }}">
                        <i class="fas fa-users mr-2"></i> Customers
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80 {{ request()->routeIs('products.*') ? 'bg-[#AB644B]' : '' }}">
                        <i class="fas fa-box mr-2"></i> Products
                    </a>
                    <a href="{{ route('preorders.index') }}" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-clipboard-list mr-2"></i> Pre-orders
                    </a>
                    <a href="{{ route('ar.index') }}" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-dollar-sign mr-2"></i> Account Receivables
                    </a>
                    <a href="{{ route('payments.index') }}" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-money-bill-wave mr-2"></i> Payments
                    </a>
                    <a href="{{ route('sales.index') }}" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-chart-line mr-2"></i> Sales
                    </a>
                </nav>
            </div>
            <div class="absolute bottom-0 w-full p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-button block w-full py-2 px-4 rounded text-white bg-[#72383D] hover:bg-[#401B1B]">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div id="mainContent" class="flex-1 ml-64 transition-all duration-300 ease-in-out">
            <div class="top-bar p-4 shadow-md flex justify-between items-center">
                <button id="toggleSidebar" class="text-[#401B1B] focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex items-center space-x-4">
                    @if(Auth::check() && Auth::user()->is_admin)
                        <livewire:admin.notification-bell />
                    @endif
                    <h2 class="text-2xl font-semibold text-[#401B1B]">{{ $title ?? '' }}</h2>
                    <div class="text-sm text-[#72383D]">{{ now()->format('l, F j, Y') }}</div>
                </div>
            </div>

            <div class="content-card m-6 p-6 rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>

    
    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleButton = document.getElementById('toggleSidebar');
            
            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                mainContent.classList.toggle('ml-0');
                mainContent.classList.toggle('ml-64');
            });

            // Add active class to current sidebar button
            const currentPath = window.location.pathname;
            const sidebarButtons = document.querySelectorAll('.sidebar-button');
            sidebarButtons.forEach(button => {
                if (button.getAttribute('href') === currentPath) {
                    button.classList.add('active');
                }
            });
        });
    </script>

    @stack('scripts')

    <!-- Floating Chat Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="{{ route('admin.messages') }}"
           class="flex items-center justify-center w-14 h-14 bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white rounded-full shadow-lg hover:from-[#401B1B] hover:to-[#72383D] transition-all duration-300">
            <i class="fas fa-comments text-2xl"></i>
            @if(auth()->user()->unreadMessages()->count() > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                    {{ auth()->user()->unreadMessages()->count() }}
                </span>
            @endif
        </a>
    </div>
</body>
</html>