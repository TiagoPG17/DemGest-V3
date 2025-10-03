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
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js para interacciones dinámicas -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- SweetAlert2 para alertas bonitas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <div class="min-h-screen flex overflow-hidden">
        <!-- Botón menú móvil flotante -->
        <button class="lg:hidden fixed top-4 left-4 z-50 p-3 bg-[rgb(60,66,80)] text-white rounded-xl shadow-lg hover:bg-[rgb(70,76,90)] transition-all duration-200 backdrop-blur-sm border border-white/20" @click="mobileMenuOpen = !mobileMenuOpen">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- Overlay para móvil -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="lg:hidden fixed inset-0 bg-black/50 z-40"></div>
        <!-- Sidebar (responsive) -->
        <aside id="sidebar" class="fixed lg:static top-0 left-0 z-40 w-64 bg-[rgb(60,66,80)] text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col min-h-screen" 
                 :class="{ 'translate-x-0': mobileMenuOpen }">
                
                <!-- Botón cerrar móvil -->
                <button class="lg:hidden absolute top-4 right-4 z-50 p-2 text-white/80 hover:text-white transition-colors duration-200" @click="mobileMenuOpen = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="p-4">
                    <!-- Logo de la aplicación -->
                    <div class="flex flex-col items-center mb-3">
                        <div class="">
                            <img src="{{ asset('images/logo.png') }}" alt="DemGest Logo" class="h-50 w-auto object-contain drop-shadow-2xl filter brightness-110">
                        </div>
                        <div class="bg-gradient-to-r from-blue-500/30 to-purple-500/30 backdrop-blur-sm rounded-lg px-4 py-2 border border-blue-400/30 shadow-md">
                            <span class="text-blue-200 text-sm font-bold tracking-wider drop-shadow-lg">Sistema de Gestión</span>
                        </div>
                    </div>
                </div>
                
                <!-- Navegación de la sidebar -->
                <nav class="flex-1 px-2 lg:px-4 pb-4 overflow-y-auto">
                    <div class="space-y-1 lg:space-y-2">
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center px-3 lg:px-5 py-3 lg:py-4 text-gray-300 rounded-xl lg:rounded-2xl hover:bg-gray-700 hover:text-white transition-all duration-300 hover:scale-110 hover:opacity-100 hover:shadow-lg hover:shadow-blue-500/50 hover:z-10 {{ request()->is('/') ? 'text-white bg-gradient-to-r from-blue-600/30 to-blue-500/20 border-l-4 border-blue-400 shadow-lg' : '' }}" @click.stop>
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-3 lg:mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="font-semibold text-base lg:text-lg">Inicio</span>
                        </a>
                        
                        @if(is_admin() || is_gestion_humana() || is_jefe())
                            <a href="{{ route('empleados.index') }}" class="nav-link flex items-center px-3 lg:px-5 py-3 lg:py-4 text-gray-300 rounded-xl lg:rounded-2xl hover:bg-gray-700 hover:text-white transition-all duration-300 hover:scale-110 hover:opacity-100 hover:shadow-lg hover:shadow-blue-500/50 hover:z-10 {{ request()->is('empleados') || request()->is('empleados/*') ? 'text-white bg-gradient-to-r from-blue-600/30 to-blue-500/20 border-l-4 border-blue-400 shadow-lg' : '' }}" @click.stop>
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-3 lg:mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 21v-2a4 2 0 0 0-3-3.87" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <span class="font-semibold text-base lg:text-lg">Empleados</span>
                            </a>
                        @endif
                        
                        @if(is_admin() || is_gestion_humana())
                            <a href="{{ route('contratos.index') }}" class="nav-link flex items-center px-3 lg:px-5 py-3 lg:py-4 text-gray-300 rounded-xl lg:rounded-2xl hover:bg-gray-700 hover:text-white transition-all duration-300 hover:scale-110 hover:opacity-100 hover:shadow-lg hover:shadow-blue-500/50 hover:z-10 {{ request()->is('contratos') || request()->is('contratos/*') || request()->is('reportes') || request()->is('reportes/*') ? 'text-white bg-gradient-to-r from-blue-600/30 to-blue-500/20 border-l-4 border-blue-400 shadow-lg' : '' }}" @click.stop>
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-3 lg:mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                    <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="14 2 14 8 20 8" />
                                    <line stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="16" y1="13" x2="8" y2="13" />
                                    <line stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="16" y1="17" x2="8" y2="17" />
                                    <line stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="10" y1="9" x2="8" y2="9" />
                                </svg>
                                <span class="font-semibold text-base lg:text-lg">Reporte</span>
                            </a>
                        @endif
                        
                        @if(is_empleado())
                            <a href="#" class="nav-link flex items-center px-3 lg:px-5 py-3 lg:py-4 text-gray-300 rounded-xl lg:rounded-2xl hover:bg-gradient-to-r hover:from-white/15 hover:to-white/5 hover:text-white transition-all duration-300 hover:scale-110 hover:opacity-100 hover:shadow-lg hover:shadow-blue-500/50 hover:z-10 overflow-hidden">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-3 lg:mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-semibold text-base lg:text-lg">Mi Información</span>
                            </a>
                        @endif
                    </div>                    
                </nav>                
                
                <!-- Espacio para empujar el contenedor hacia abajo -->
                <div class="flex-grow"></div>
                
                <!-- Contenedor de usuario mejorado con menú desplegable -->
                @auth
                <div style="padding: 16px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(139, 92, 246, 0.08)); backdrop-filter: blur(10px); border-top: 1px solid rgba(255, 255, 255, 0.06);" x-data="{ userMenuOpen: false }" x-init="userMenuOpen = false">
                    <!-- Botón principal del usuario (clicable) -->
                    <button @click="userMenuOpen = !userMenuOpen" style="width: 100%; background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; gap: 12px; transition: all 0.2s ease; outline: none !important; box-shadow: none !important;" 
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <style>
                            button:focus {
                                outline: none !important;
                                box-shadow: none !important;
                                border: none !important;
                            }
                            button::-moz-focus-inner {
                                border: 0 !important;
                            }
                        </style>
                        <!-- Avatar mejorado -->
                        <div style="position: relative;">
                            <!-- Anillo sutil -->
                            <div style="position: absolute; top: -3px; left: -3px; right: -3px; bottom: -3px; background: linear-gradient(45deg, rgba(59, 130, 246, 0.3), rgba(139, 92, 246, 0.3), rgba(236, 72, 153, 0.3)); border-radius: 50%; animation: rotate 6s linear infinite;"></div>
                            <!-- Avatar principal -->
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3), 0 2px 6px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; position: relative; z-index: 2;" onmouseover="this.style.transform='scale(1.08)'; this.style.boxShadow='0 6px 16px rgba(59, 130, 246, 0.4), 0 4px 8px rgba(0, 0, 0, 0.3)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 12px rgba(59, 130, 246, 0.3), 0 2px 6px rgba(0, 0, 0, 0.2)'">
                                <span style="color: white; font-weight: bold; font-size: 16px; text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <!-- Indicador de estado -->
                            <div style="position: absolute; bottom: 1px; right: 1px; width: 10px; height: 10px; background: #10b981; border-radius: 50%; border: 2px solid #3c4250; box-shadow: 0 0 8px rgba(16, 185, 129, 0.5); animation: pulse 2s infinite; z-index: 3;"></div>
                        </div>
                        
                        <!-- Información minimalista -->
                        <div style="flex: 1; min-width: 0; text-align: left;">
                            <p style="color: white; font-size: 15px; font-weight: 600; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);">
                                {{ Auth::user()->name }}
                            </p>
                            <p style="color: rgba(255, 255, 255, 0.6); font-size: 11px; margin: 1px 0 0 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ Auth::user()->email }}
                            </p>
                            
                            <!-- Rol con ícono y background chimba -->
                            <div style="margin-top: 6px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1), rgba(236, 72, 153, 0.1)); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 6px 10px; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.1);">
                                @if(is_admin())
                                    <div style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border-radius: 50%; padding: 4px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);">
                                        <svg style="width: 12px; height: 12px; color: #fca5a5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <span style="color: #fca5a5; font-size: 11px; font-weight: 600; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">Administrador</span>
                                @elseif(is_gestion_humana())
                                    <div style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border-radius: 50%; padding: 4px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);">
                                        <svg style="width: 12px; height: 12px; color: #86efac;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <span style="color: #86efac; font-size: 11px; font-weight: 600; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">Gestión Humana</span>
                                @elseif(is_jefe())
                                    <div style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.1)); border-radius: 50%; padding: 4px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);">
                                        <svg style="width: 12px; height: 12px; color: #fcd34d;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                        </svg>
                                    </div>
                                    <span style="color: #fcd34d; font-size: 11px; font-weight: 600; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">Jefe</span>
                                @else
                                    <div style="background: linear-gradient(135deg, rgba(107, 114, 128, 0.2), rgba(107, 114, 128, 0.1)); border-radius: 50%; padding: 4px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3);">
                                        <svg style="width: 12px; height: 12px; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span style="color: #d1d5db; font-size: 11px; font-weight: 600; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">Empleado</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Icono de flecha (indicador de menú) -->
                        <div style="transition: transform 0.3s ease;" :style="userMenuOpen ? 'transform: rotate(180deg)' : ''">
                            <svg style="width: 16px; height: 16px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    
                    <!-- Menú desplegable -->
                    <div x-show="userMenuOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2" 
                         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
                         @click.away="userMenuOpen = false"
                         style="margin-top: 12px; background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(51, 65, 85, 0.95)); backdrop-filter: blur(10px); border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3); overflow: hidden;">
                        
                        <!-- Opción de perfil -->
                        <a href="{{ route('profile.edit') }}" style="width: 100%; padding: 12px 16px; background: none; border: none; color: white; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 12px; text-align: left; text-decoration: none;" 
                           onmouseover="this.style.background='linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.3))'; this.style.paddingLeft='20px'" 
                           onmouseout="this.style.background='none'; this.style.paddingLeft='16px'">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.3)); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 16px; height: 16px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div style="font-weight: 600; margin-bottom: 2px;">Mi Perfil</div>
                                <div style="font-size: 12px; color: rgba(255, 255, 255, 0.6);">Gestionar cuenta y seguridad</div>
                            </div>
                        </a>
                        
                        <!-- Divisor -->
                        <div style="height: 1px; background: rgba(255, 255, 255, 0.1); margin: 4px 16px;"></div>
                        
                        <!-- Opción de cerrar sesión -->
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; padding: 12px 16px; background: none; border: none; color: white; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 12px; text-align: left;" 
                                    onmouseover="this.style.background='linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 38, 38, 0.3))'; this.style.paddingLeft='20px'" 
                                    onmouseout="this.style.background='none'; this.style.paddingLeft='16px'">
                                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 38, 38, 0.3)); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <svg style="width: 16px; height: 16px; color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div style="font-weight: 600; margin-bottom: 2px;">Cerrar Sesión</div>
                                    <div style="font-size: 12px; color: rgba(255, 255, 255, 0.6);">Salir de la aplicación</div>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
                <style>
                    @keyframes pulse {
                        0% { transform: scale(1); opacity: 1; }
                        50% { transform: scale(1.15); opacity: 0.8; }
                        100% { transform: scale(1); opacity: 1; }
                    }
                    @keyframes rotate {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                    /* Prevenir parpadeo de elementos Alpine antes de inicializar */
                    [x-cloak] { display: none !important; }
                </style>
                @endauth
            </aside>
            
            <!-- Área principal de contenido -->
            <main class="flex-1 overflow-auto bg-gray-50">
                <div class="p-4 lg:p-6 min-h-screen">
                    <div class="max-w-6xl mx-auto lg:pl-4">
                        <!-- Sistema de Alertas Unificado -->
                        @include('components.alertas')
                        
                        @yield('content')
                    </div>
                </div>
            </main>
    </div>
    
    @stack('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('app', () => ({
                mobileMenuOpen: false,
                init() {
                    // Cerrar menú móvil al cambiar de tamaño de ventana
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 1024) {
                            this.mobileMenuOpen = false;
                        }
                    });
                    
                    // Cerrar menú móvil al hacer click fuera
                    document.addEventListener('click', (event) => {
                        const sidebar = document.querySelector('aside');
                        const menuButton = document.querySelector('[x-click*="mobileMenuOpen"]');
                        
                        if (this.mobileMenuOpen && 
                            sidebar && 
                            !sidebar.contains(event.target) && 
                            menuButton && 
                            !menuButton.contains(event.target)) {
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