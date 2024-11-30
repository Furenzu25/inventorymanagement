<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<body>
    {{ $slot }}
    @livewireScripts
    <script>
        document.addEventListener('livewire:initialized', () => {
            console.log('Livewire initialized');
        });
    </script>
</body>
</html> 