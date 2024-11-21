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

        .company-name {
            background: linear-gradient(45deg, var(--color-primary), var(--color-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .auth-card {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div id="app-wrapper" class="min-h-screen">
        <?php echo e($slot); ?>

    </div>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views/components/layouts/guest.blade.php ENDPATH**/ ?>