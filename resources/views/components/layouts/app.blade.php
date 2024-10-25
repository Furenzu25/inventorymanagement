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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #ffffff;
            z-index: 100;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            transition: transform 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        #sidebar.hidden {
            transform: translateX(-250px);
        }

        .sidebar-button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 12px 15px;
            color: #64748b;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .sidebar-button:hover, .sidebar-button.active {
            background-color: #f1f5f9;
            color: #3b82f6;
        }

        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px;
            background-color: #ffffff;
            color: #64748b;
            border-radius: 8px;
            cursor: pointer;
            z-index: 101;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            background-color: #ffffff;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .content-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 20px;
        }
    </style>
</head>

<body>
    <div id="app-wrapper" class="relative min-h-screen">
        
        {{-- SIDEBAR --}}
        <div id="sidebar">
            <div class="mb-6 text-center">
                <h1 class="text-xl font-bold text-gray-800">Rosels Trading</h1>
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
            <a href="{{ route('sales.index') }}" class="sidebar-button">
                <i class="fas fa-dollar-sign mr-2"></i> Sales
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
                <h2 class="text-2xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
            </div>

            <div class="content-card">
                {{ $slot }}
            </div>
        </div>
    </div>

    <div id="modal-container"></div>

    @livewireScripts

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('collapsed');
        });
    </script>
</body>
</html>
