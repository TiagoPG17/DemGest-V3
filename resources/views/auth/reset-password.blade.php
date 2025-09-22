<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GHconnecting') }} - Restablecer Contraseña</title>

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
        
        <!-- Tarjeta de reset password -->
        <div class="relative z-10 w-full max-w-md mx-4">
            <div class="bg-white/10 backdrop-blur-lg shadow-2xl rounded-2xl p-8 space-y-6 border border-white/20">
                <!-- Encabezado -->
                <div class="text-center space-y-4">
                    <div class="flex justify-center transform hover:scale-105 transition-transform duration-300">
                        <div class="w-20 h-20 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center shadow-lg">
                            <img src="{{ asset('images/icono_logo.png') }}" alt="Logo" class="w-12 h-12">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white via-purple-100 to-white mb-2 tracking-tight">
                            Restablecer Contraseña
                        </h1>
                        <p class="text-white/80 text-sm leading-relaxed">
                            Ingresa tu nueva contraseña para continuar
                        </p>
                    </div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-white/90 tracking-wide">Correo electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-white/60"></i>
                            </div>
                            <input id="email" class="block w-full pl-10 pr-3 py-3 border border-white/30 rounded-xl bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="tu@correo.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-white/90 tracking-wide">Nueva Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-white/60"></i>
                            </div>
                            <input id="password" class="block w-full pl-10 pr-3 py-3 border border-white/30 rounded-xl bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-white/90 tracking-wide">Confirmar Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-white/60"></i>
                            </div>
                            <input id="password_confirmation" class="block w-full pl-10 pr-3 py-3 border border-white/30 rounded-xl bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-xl transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-transparent shadow-lg">
                            Restablecer Contraseña
                        </button>
                    </div>
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
