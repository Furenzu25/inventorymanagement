<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Rosels Trading') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN (fallback) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #F2F2EB, #D2DCE6);
            min-height: 100vh;
        }
        .gradient-button {
            background: linear-gradient(to right, #72383D, #AB644B);
            transition: all 0.3s ease;
        }
        .gradient-button:hover {
            background: linear-gradient(to right, #401B1B, #72383D);
            transform: translateY(-2px);
        }
        .logo-text {
            background: linear-gradient(45deg, #401B1B, #72383D);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/3 bg-gradient-to-b from-[#401B1B] to-[#72383D] p-8 flex flex-col justify-center items-center text-white">
                    <h1 class="text-3xl font-bold mb-4">Rosels Trading</h1>
                    <p class="text-center mb-6">Inventory Management System</p>
                </div>
                <div class="md:w-2/3 p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold logo-text">Welcome Back!</h2>
                        <p class="text-gray-600 mt-2">Please login to access your inventory management dashboard</p>
                    </div>
                    
                    <div class="space-y-4">
                        <a href="{{ route('login') }}" class="gradient-button block w-full py-3 text-center rounded-lg text-white font-medium shadow-md">
                            Login to Dashboard
                        </a>
                        
                        <a href="{{ route('register') }}" class="block w-full py-3 text-center rounded-lg border border-[#72383D] text-[#72383D] font-medium hover:bg-gray-50 transition duration-300">
                            Create New Account
                        </a>
                    </div>
                    
                    <div class="mt-8 text-center text-sm text-gray-500">
                        <p>© {{ date('Y') }} Rosels Trading. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 