<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DemGest') }}</title>

    <!-- Fonts: Preconnect y carga de Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Assets compilados con Vite (CSS y JS) -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js para interacciones dinámicas -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
    <div class="min-h-screen flex">
        <!-- Sidebar (visible en desktop) -->
        <aside class="w-64 bg-[rgb(60,66,80)] text-white hidden md:block">
            <div class="p-4">
                <!-- Logo de la aplicación -->
                <div class="flex flex-col items-center mb-2">
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-2 border border-white/10 shadow-lg mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="GHconnecting Logo" class="h-32 w-auto object-contain drop-shadow-lg hover:drop-shadow-xl transition-all duration-300 hover:scale-105">
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm rounded-lg px-4 py-1.5 border border-white/10 shadow-sm">
                        <span class="text-blue-400 text-sm font-medium tracking-wide">Sistema de Gestión</span>
                    </div>
                </div>
            </div>
            <!-- Navegación de la sidebar -->
            <nav class="">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Inicio
                </a>
                <a href="{{ route('empleados.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Empleados
                </a>
                <a href="{{ route('contratos.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg>
                    Reporte
                </a>
            </nav>
        </aside>
        <!-- Área principal de contenido -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1 overflow-auto p-5">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>