<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GHconnecting') }} - Iniciar Sesión</title>

    <!-- Favicon personalizado -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icono_logo.png') }}?v={{ time() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/icono_logo.png') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icono_logo.png') }}?v={{ time() }}">
    

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
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center bg-[rgb(60,66,80)] relative overflow-hidden">
        <!-- Elementos decorativos animados más notorios -->
        <div class="absolute top-0 left-0 w-80 h-80 bg-purple-600/40 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute top-1/4 right-0 w-64 h-64 bg-blue-600/35 rounded-full filter blur-3xl animate-pulse animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-pink-600/40 rounded-full filter blur-3xl animate-pulse animation-delay-1000"></div>
        <div class="absolute bottom-1/4 right-1/4 w-56 h-56 bg-indigo-600/35 rounded-full filter blur-3xl animate-pulse animation-delay-3000"></div>
        <!-- Elementos adicionales para más animación -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-cyan-600/20 rounded-full filter blur-3xl animate-pulse animation-delay-1500"></div>
        <div class="absolute top-1/3 left-1/3 w-48 h-48 bg-emerald-600/25 rounded-full filter blur-3xl animate-pulse animation-delay-2500"></div>
        
        <!-- Nuevos elementos con diferentes animaciones -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-yellow-500/30 rounded-full filter blur-2xl animate-bounce animation-delay-500"></div>
        <div class="absolute bottom-20 right-20 w-40 h-40 bg-red-500/25 rounded-full filter blur-2xl animate-bounce animation-delay-3000"></div>
        <div class="absolute top-1/4 left-3/4 w-24 h-24 bg-green-500/35 rounded-full filter blur-xl animate-spin animation-delay-1000" style="animation-duration: 8s;"></div>
        <div class="absolute bottom-1/3 right-1/4 w-36 h-36 bg-orange-500/30 rounded-full filter blur-2xl animate-ping animation-delay-2000" style="animation-duration: 3s;"></div>
        <div class="absolute top-3/4 left-1/5 w-28 h-28 bg-teal-500/40 rounded-full filter blur-xl animate-bounce animation-delay-1500"></div>
        <div class="absolute top-1/5 right-1/5 w-44 h-44 bg-violet-500/25 rounded-full filter blur-2xl animate-ping animation-delay-3500" style="animation-duration: 4s;"></div>
        
        <!-- Tarjeta de login -->
        <div class="relative z-10 w-full max-w-md mx-4">
            <div class="bg-white/10 backdrop-blur-lg shadow-2xl rounded-2xl p-8 space-y-6 border border-white/20">
                <!-- Encabezado -->
                <div class="text-center space-y-4">
                    <div class="flex justify-center transform hover:scale-105 transition-transform duration-300">
                        <div class="w-20 h-20 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center shadow-lg">
                            <img src="{{ asset('images/icono_logo.png') }}" alt="Logo" class="w-16 h-16">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white via-purple-100 to-white mb-2 tracking-tight">
                            Bienvenido de nuevo
                        </h1>
                        <p class="text-white/80 text-sm leading-relaxed">
                            Ingresa tus credenciales para acceder a tu cuenta
                        </p>
                    </div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-white/90 tracking-wide">Correo electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="correo@ejemplo.com"
                                class="w-full pl-10 pr-4 py-3 bg-white/10 text-white placeholder-white/60 border border-white/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:bg-white/15"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-300 text-sm" />
                    </div>

                    <!-- Contraseña -->
                    <div x-data='{"showPassword": false}' class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-white/90 tracking-wide">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <x-text-input id="password" name="password" x-bind:type="showPassword ? 'text' : 'password'" required autocomplete="current-password" placeholder="********"
                                class="w-full pl-10 pr-12 py-3 bg-white/10 text-white placeholder-white/60 border border-white/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:bg-white/15"
                            />
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center hover:text-white/70 transition-colors duration-200">
                                <svg x-show="!showPassword" class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242"></path>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-300 text-sm" />
                    </div>

                    <!-- Opciones de recordarme y olvido contraseña -->
                    <div class="flex items-center justify-between pt-2">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 border-white/30 rounded focus:ring-blue-500 focus:ring-offset-0 bg-white/10">
                            <label for="remember_me" class="ml-2 text-sm text-white/90 hover:text-white transition-colors duration-200">Recordarme</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-200 hover:text-blue-100 hover:underline transition-all duration-200">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>

                    <!-- Botón de iniciar sesión -->
                    <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 hover:from-blue-800 hover:via-blue-700 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg transform transition-all duration-300 hover:scale-[1.02] hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-transparent">
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Iniciar sesión</span>
                        </span>
                    </button>

                </form>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes animation-delay-1000 {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes animation-delay-1500 {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes animation-delay-2000 {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes animation-delay-2500 {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes animation-delay-3000 {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes animation-delay-3500 {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes animation-delay-500 {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</body>
</html>