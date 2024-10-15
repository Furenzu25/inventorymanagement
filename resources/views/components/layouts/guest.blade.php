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
    </style>
</head>
<body class="font-sans antialiased">
    {{ $slot }}

    @livewireScripts
</body>
</html>
