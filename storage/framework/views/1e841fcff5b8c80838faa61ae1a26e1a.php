<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(isset($title) ? $title.' | '.config('app.name') : config('app.name')); ?></title>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <style>
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
    </style>
</head>

<body class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6]">
    <div id="app-wrapper" class="relative min-h-screen flex">
        
        
        <div id="sidebar" class="w-64 fixed top-0 left-0 h-full z-40 transition-transform duration-300 ease-in-out transform">
            <div class="p-6">
                <h1 class="company-name text-2xl font-bold mb-6 text-center">Rosels Trading</h1>
                
                <nav class="space-y-2">
                    <a href="/dashboard" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="<?php echo e(route('inventory.index')); ?>" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-box mr-2"></i> Inventory
                    </a>    
                    <a href="<?php echo e(route('customers.index')); ?>" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-users mr-2"></i> Customers
                    </a>
                    <a href="<?php echo e(route('products.index')); ?>" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-box mr-2"></i> Products
                    </a>
                    <a href="<?php echo e(route('preorders.index')); ?>" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-clipboard-list mr-2"></i> Pre-orders
                    </a>
                    <a href="<?php echo e(route('ar.index')); ?>" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-dollar-sign mr-2"></i> Account Receivables
                    </a>
                    <a href="<?php echo e(route('payments.index')); ?>" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-money-bill-wave mr-2"></i> Payments
                    </a>
                    <a href="<?php echo e(route('sales.index')); ?>" class="sidebar-button block w-full py-2 px-4 rounded text-white hover:bg-opacity-80">
                        <i class="fas fa-chart-line mr-2"></i> Sales
                    </a>
                </nav>
            </div>
            <div class="absolute bottom-0 w-full p-4">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="sidebar-button block w-full py-2 px-4 rounded text-white bg-[#72383D] hover:bg-[#401B1B]">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        
        <div id="mainContent" class="flex-1 ml-64 transition-all duration-300 ease-in-out">
            <div class="top-bar p-4 shadow-md flex justify-between items-center">
                <button id="toggleSidebar" class="text-[#401B1B] focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex items-center space-x-4">
                    <?php if(Auth::check() && Auth::user()->is_admin): ?>
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.notification-bell', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-598004296-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <?php endif; ?>
                    <h2 class="text-2xl font-semibold text-[#401B1B]"><?php echo e($title ?? ''); ?></h2>
                    <div class="text-sm text-[#72383D]"><?php echo e(now()->format('l, F j, Y')); ?></div>
                </div>
            </div>

            <div class="content-card m-6 p-6 rounded-lg">
                <?php echo e($slot); ?>

            </div>
        </div>
    </div>

    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


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
</body>
</html><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\components\layouts\app.blade.php ENDPATH**/ ?>