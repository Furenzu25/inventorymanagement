<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' | '.config('app.name') : config('app.name') }}</title>
    
    @livewireStyles
    
    <!-- Using a try-catch block to handle potential Vite errors -->
    @php
    $viteCssPath = null;
    $viteJsPath = null;
    
    try {
        $viteManifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        if (isset($viteManifest['resources/css/app.css']['file'])) {
            $viteCssPath = 'build/' . $viteManifest['resources/css/app.css']['file'];
        }
        if (isset($viteManifest['resources/js/app.js']['file'])) {
            $viteJsPath = 'build/' . $viteManifest['resources/js/app.js']['file'];
        }
    } catch (\Exception $e) {
        // Manifest file not found or invalid
    }
    @endphp
    
    @if($viteCssPath && $viteJsPath)
        <!-- Vite assets found, use them -->
        <link rel="stylesheet" href="{{ asset($viteCssPath) }}">
        <script type="module" src="{{ asset($viteJsPath) }}"></script>
    @else
        <!-- Fallback to @vite directive -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Additional CDN fallbacks -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @endif

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
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
