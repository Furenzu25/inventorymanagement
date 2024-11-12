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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-color: #f4f7f9;
            --text-color: #34495e;
            --sidebar-bg: #2c3e50;
            --sidebar-text: #ecf0f1;
            --card-bg: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: var(--sidebar-bg);
            z-index: 100;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        #sidebar.hidden {
            transform: translateX(-250px);
        }

        .sidebar-button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 12px 15px;
            color: var(--sidebar-text);
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .sidebar-button:hover, .sidebar-button.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 270px;
            padding: 10px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            cursor: pointer;
            z-index: 101;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background-color: var(--secondary-color);
            transform: scale(1.1);
        }

        .sidebar-toggle.collapsed {
            left: 20px;
        }

        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            padding: 20px;
        }

        .main-content.collapsed {
            margin-left: 0;
        }

        .top-bar {
            background-color: var(--card-bg);
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            transition: box-shadow 0.3s ease;
        }

        .content-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Gradient text effect for the company name */
        .company-name {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 700;
            font-size: 1.5rem;
        }

        /* Subtle animation for sidebar icons */
        .sidebar-button i {
            transition: transform 0.2s ease;
        }

        .sidebar-button:hover i {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <div id="app-wrapper" class="relative min-h-screen">
        
        {{-- SIDEBAR --}}
        <div id="sidebar">
            <div class="mb-6 text-center">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="h-12 w-auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 16V8.00002C20.9996 7.6493 20.9071 7.30483 20.7315 7.00119C20.556 6.69754 20.3037 6.44539 20 6.27002L13 2.27002C12.696 2.09449 12.3511 2.00208 12 2.00208C11.6489 2.00208 11.304 2.09449 11 2.27002L4 6.27002C3.69626 6.44539 3.44398 6.69754 3.26846 7.00119C3.09294 7.30483 3.00036 7.6493 3 8.00002V16C3.00036 16.3508 3.09294 16.6952 3.26846 16.9989C3.44398 17.3025 3.69626 17.5547 4 17.73L11 21.73C11.304 21.9056 11.6489 21.998 12 21.998C12.3511 21.998 12.696 21.9056 13 21.73L20 17.73C20.3037 17.5547 20.556 17.3025 20.7315 16.9989C20.9071 16.6952 20.9996 16.3508 21 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h1 class="company-name">Rosels Trading</h1>
                </div>
            </div>
            {{-- Sidebar buttons --}}
            <a href="/dashboard" class="sidebar-button">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            <a href="{{ route('customers.index') }}" class="sidebar-button">
                <i class="fas fa-users mr-2"></i> Customers
            </a>
            <a href="{{ route('products.index') }}" class="sidebar-button">
                <i class="fas fa-box mr-2"></i> Products
            </a>
            <a href="{{ route('preorders.index') }}" class="sidebar-button">
                <i class="fas fa-clipboard-list mr-2"></i> Pre-orders
            </a>
            <a href="{{ route('ar.index') }}" class="sidebar-button">
                <i class="fas fa-dollar-sign mr-2"></i> Account Receivables
            </a>
            <a href="{{ route('payments.index') }}" class="sidebar-button">
                <i class="fas fa-money-bill-wave mr-2"></i> Payments
            </a>
            <a href="{{ route('payments.history', ['sale' => 'all']) }}" class="sidebar-button">
                <i class="fas fa-history mr-2"></i> Payment History
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="sidebar-button">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>

        {{-- Sidebar Toggle Button --}}
        <button id="toggleSidebar" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>

        {{-- MAIN CONTENT --}}
        <div id="mainContent" class="main-content">
            <div class="top-bar">
                <h2 class="text-2xl font-semibold text-gray-800">{{ $title ?? '' }}</h2>
                <div class="text-sm text-gray-600">{{ now()->format('l, F j, Y') }}</div>
            </div>

            <div class="content-card">
                {{ $slot }}
            </div>
        </div>
    </div>

    <div id="modal-container"></div>

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleButton = document.getElementById('toggleSidebar');
            
            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                mainContent.classList.toggle('collapsed');
                toggleButton.classList.toggle('collapsed');
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
</body>
</html>
