<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DemGest') }}</title>

    <!-- Favicon personalizado -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icono_logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/icono_logo.png') }}">

    <!-- Fonts: Preconnect y carga de Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Assets compilados con Vite (CSS y JS) -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js para interacciones dinámicas -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex overflow-hidden">
        <!-- Botón menú móvil flotante -->
        <button class="md:hidden fixed top-4 left-4 z-20 p-2 bg-[rgb(60,66,80)] text-white rounded-lg shadow-lg hover:bg-[rgb(70,76,90)] transition-colors duration-200" @click="mobileMenuOpen = !mobileMenuOpen">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <div class="flex flex-1">
            <!-- Sidebar (visible en desktop) -->
            <aside class="w-64 bg-[rgb(60,66,80)] text-white hidden md:flex md:flex-col transition-all duration-300 ease-in-out" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                <div class="p-4">
                    <!-- Logo de la aplicación -->
                    <div class="flex flex-col items-center mb-3">
                        <div class="bg-gradient-to-br from-white/15 to-white/5 backdrop-blur-sm rounded-xl p-1 border border-white/15 shadow-lg mb-5 transform hover:scale-110 transition-all duration-500 hover:rotate-1">
                            <img src="{{ asset('images/logo.png') }}" alt="DemGest Logo" class="h-50 w-auto object-contain drop-shadow-2xl filter brightness-110">
                        </div>
                        <div class="bg-gradient-to-r from-blue-500/30 to-purple-500/30 backdrop-blur-sm rounded-lg px-4 py-2 border border-blue-400/30 shadow-md">
                            <span class="text-blue-200 text-sm font-bold tracking-wider drop-shadow-lg">Sistema de Gestión</span>
                        </div>
                    </div>
                </div>
                
                <!-- Navegación de la sidebar -->
                <nav class="flex-1 px-4 pb-4">
                    <div class="space-y-3">
                        <a href="{{ route('dashboard') }}" class="nav-link group relative flex items-center px-5 py-4 text-gray-300 rounded-2xl hover:bg-gradient-to-r hover:from-white/15 hover:to-white/5 hover:text-white transition-all duration-300 transform hover:translate-x-1 hover:shadow-lg overflow-hidden {{ request()->is('/') || request()->is('dashboard') || request()->is('home') ? 'text-white bg-gradient-to-r from-blue-600/30 to-blue-500/20 border-l-4 border-blue-400 shadow-lg' : '' }}">
                            <!-- Efecto de fondo animado -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->is('/') || request()->is('dashboard') || request()->is('home') ? 'opacity-100 animate-pulse' : '' }}"></div>
                            <!-- Icono -->
                            <svg class="w-6 h-6 mr-4 group-hover:scale-125 transition-transform duration-300 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="9 22 9 12 15 12 15 22" />
                            </svg>
                            <span class="font-semibold text-lg relative z-10">Inicio</span>
                            <!-- Indicador hover/activo -->
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-8 bg-blue-400 rounded-full {{ request()->is('/') || request()->is('dashboard') || request()->is('home') ? 'opacity-100 shadow-lg' : 'opacity-0 group-hover:opacity-100' }} transition-opacity duration-300"></div>
                        </a>
                        
                        <a href="{{ route('empleados.index') }}" class="nav-link group relative flex items-center px-5 py-4 text-gray-300 rounded-2xl hover:bg-gradient-to-r hover:from-white/15 hover:to-white/5 hover:text-white transition-all duration-300 transform hover:translate-x-1 hover:shadow-lg overflow-hidden {{ request()->is('empleados') || request()->is('empleados/*') ? 'text-white bg-gradient-to-r from-blue-600/30 to-blue-500/20 border-l-4 border-blue-400 shadow-lg' : '' }}">
                            <!-- Efecto de fondo animado -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->is('empleados') || request()->is('empleados/*') ? 'opacity-100 animate-pulse' : '' }}"></div>
                            <!-- Icono -->
                            <svg class="w-6 h-6 mr-4 group-hover:scale-125 transition-transform duration-300 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 21v-2a4 2 0 0 0-3-3.87" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            <span class="font-semibold text-lg relative z-10">Empleados</span>
                            <!-- Indicador hover/activo -->
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-8 bg-blue-400 rounded-full {{ request()->is('empleados') || request()->is('empleados/*') ? 'opacity-100 shadow-lg' : 'opacity-0 group-hover:opacity-100' }} transition-opacity duration-300"></div>
                        </a>
                        
                        <a href="{{ route('contratos.index') }}" class="nav-link group relative flex items-center px-5 py-4 text-gray-300 rounded-2xl hover:bg-gradient-to-r hover:from-white/15 hover:to-white/5 hover:text-white transition-all duration-300 transform hover:translate-x-1 hover:shadow-lg overflow-hidden {{ request()->is('reportes/contratos') || request()->is('reportes/contratos/*') ? 'text-white bg-gradient-to-r from-blue-600/30 to-blue-500/20 border-l-4 border-blue-400 shadow-lg' : '' }}">
                            <!-- Efecto de fondo animado -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->is('reportes/contratos') || request()->is('reportes/contratos/*') ? 'opacity-100 animate-pulse' : '' }}"></div>
                            <!-- Icono -->
                            <svg class="w-6 h-6 mr-4 group-hover:scale-125 transition-transform duration-300 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="14 2 14 8 20 8" />
                                <line stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="16" y1="13" x2="8" y2="13" />
                                <line stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="16" y1="17" x2="8" y2="17" />
                                <line stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="10" y1="9" x2="8" y2="9" />
                            </svg>
                            <span class="font-semibold text-lg relative z-10">Reporte</span>
                            <!-- Indicador hover/activo -->
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-8 bg-blue-400 rounded-full {{ request()->is('reportes/contratos') || request()->is('reportes/contratos/*') ? 'opacity-100 shadow-lg' : 'opacity-0 group-hover:opacity-100' }} transition-opacity duration-300"></div>
                        </a>
                    </div>
                    
                </nav>
                
                <!-- Footer sidebar -->
                <div class="p-4 border-t border-white/10">
                    <div class="text-center">
                        <p class="text-xs text-gray-400">Versión 1.0.0</p>
                        <p class="text-xs text-gray-500 mt-1">© 2025 GHconnecting</p>
                    </div>
                </div>
            </aside>
            
            <!-- Área principal de contenido -->
            <main class="flex-1 overflow-auto bg-gray-50">
                <div class="p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('app', () => ({
                mobileMenuOpen: false,
                init() {
                    // Cerrar menú móvil al cambiar de tamaño de ventana
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 768) {
                            this.mobileMenuOpen = false;
                        }
                    });
                }
            }));
        });
    </script>
    <style>
        /* Asegurar que el botón flotante no tape el contenido */
        body {
            padding-top: 0 !important;
        }
    </style>
</body>
</html>