@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Encabezado simple -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Mi Perfil</h1>
            <p class="mt-1 text-sm text-gray-600">Gestiona tu información personal y configuración de cuenta</p>
        </div>

    <!-- Mensajes de éxito -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Información Personal -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                <!-- Efecto decorativo de fondo -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-full opacity-50"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-blue-100 to-transparent rounded-full opacity-30"></div>
                
                <!-- Borde lateral decorativo -->
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-400 via-blue-500 to-blue-600 rounded-l-xl"></div>
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-blue-900">Información Personal</h2>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <label for="name" class="block text-sm font-semibold text-gray-800 mb-3">Nombre Completo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                   class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-gray-900 placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg @error('name') border-red-400 focus:ring-red-500/20 focus:border-red-500 @enderror"
                                   placeholder="Ingresa tu nombre completo" required>
                        </div>
                        @error('name')
                            <p class="mt-3 text-sm text-red-600 bg-red-50 rounded-lg p-2 border border-red-200">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <label for="email" class="block text-sm font-semibold text-gray-800 mb-3">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-gray-900 placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg @error('email') border-red-400 focus:ring-red-500/20 focus:border-red-500 @enderror"
                                   placeholder="Ingresa tu correo electrónico" required>
                        </div>
                        @error('email')
                            <p class="mt-3 text-sm text-red-600 bg-red-50 rounded-lg p-2 border border-red-200">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Rol actual</p>
                                <p class="text-xl font-bold text-gray-900">{{ formatRoleName($user->roles->first()->name) ?? 'Sin rol' }}</p>
                            </div>
                            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-lg">
                                <svg class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Contador de Sesión Simple -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Tiempo de sesión:</span>
                            </div>
                            <div id="session-time" class="text-lg font-mono font-semibold text-gray-900">00:00:00</div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar Información
                    </button>
                </form>
            </div>

        <!-- Seguridad -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 relative overflow-hidden">
            <!-- Efecto decorativo de fondo -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-50 to-transparent rounded-full opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-red-100 to-transparent rounded-full opacity-30"></div>
            
            <!-- Borde lateral decorativo -->
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-red-400 via-red-500 to-red-600 rounded-l-xl"></div>
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-red-900">Seguridad</h2>
            </div>
            
            <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <label for="current_password" class="block text-sm font-semibold text-gray-800 mb-3">Contraseña Actual</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="current_password" name="current_password" 
                               class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 text-gray-900 placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg @error('current_password') border-red-400 focus:ring-red-500/20 focus:border-red-500 @enderror"
                               placeholder="Ingresa tu contraseña actual" required
                               oninput="validateCurrentPassword(this)">
                    </div>
                    <div id="current-password-error" class="mt-3 text-sm text-red-600 bg-red-50 rounded-lg p-2 border border-red-200 hidden"></div>
                    @error('current_password')
                        <p class="mt-3 text-sm text-red-600 bg-red-50 rounded-lg p-2 border border-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <label for="password" class="block text-sm font-semibold text-gray-800 mb-3">Nueva Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" 
                               class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 text-gray-900 placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg @error('password') border-red-400 focus:ring-red-500/20 focus:border-red-500 @enderror"
                               placeholder="Ingresa tu nueva contraseña" required
                               minlength="12" maxlength="255"
                               oninput="validatePassword(this); validatePasswordMatch()">
                    </div>
                    <div id="password-error" class="mt-3 text-sm text-red-600 bg-red-50 rounded-lg p-2 border border-red-200 hidden"></div>
                    <div id="password-strength" class="mt-3"></div>
                    @error('password')
                        <p class="mt-3 text-sm text-red-600 bg-red-50 rounded-lg p-2 border border-red-200">{{ $message }}</p>
                    @enderror
                    <div class="mt-4 bg-red-50 rounded-lg p-4 border border-red-200">
                        <p class="text-xs font-semibold text-red-800 mb-2">Requisitos de seguridad:</p>
                        <ul class="text-xs text-red-700 space-y-1 ml-4">
                            <li id="req-length">• Mínimo 12 caracteres</li>
                            <li id="req-uppercase">• Al menos una mayúscula</li>
                            <li id="req-lowercase">• Al menos una minúscula</li>
                            <li id="req-number">• Al menos un número</li>
                            <li id="req-special">• Al menos un carácter especial</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-800 mb-3">Confirmar Nueva Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 text-gray-900 placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg @error('password_confirmation') border-red-400 focus:ring-red-500/20 focus:border-red-500 @enderror"
                               placeholder="Confirma tu nueva contraseña" required
                               oninput="validatePasswordMatch()">
                    </div>
                    <div id="password-match-error" class="mt-3 text-sm text-red-600 bg-red-50 rounded-lg p-2 border border-red-200 hidden"></div>
                    @error('password_confirmation')
                        <p class="mt-3 text-sm text-red-600 bg-red-50 rounded-lg p-2 border border-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Actualizar Contraseña
                </button>
            </form>
        </div>

    </div>
</div>

<script>
// Contador de tiempo de sesión simple
let sessionStartTime = localStorage.getItem('sessionStartTime');
let sessionTimeElement = document.getElementById('session-time');

if (!sessionStartTime) {
    sessionStartTime = Date.now();
    localStorage.setItem('sessionStartTime', sessionStartTime);
} else {
    sessionStartTime = parseInt(sessionStartTime);
}

function updateSessionTime() {
    const now = Date.now();
    const elapsed = now - sessionStartTime;
    
    const hours = Math.floor(elapsed / (1000 * 60 * 60));
    const minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((elapsed % (1000 * 60)) / 1000);
    
    const formattedTime = 
        String(hours).padStart(2, '0') + ':' +
        String(minutes).padStart(2, '0') + ':' +
        String(seconds).padStart(2, '0');
    
    if (sessionTimeElement) {
        sessionTimeElement.textContent = formattedTime;
    }
}

// Actualizar cada segundo
setInterval(updateSessionTime, 1000);
updateSessionTime(); // Actualizar inmediatamente

// Reiniciar contador al cerrar sesión o pestaña
function resetSessionCounter() {
    localStorage.removeItem('sessionStartTime');
}

// Detectar cuando se hace clic en enlaces de cierre de sesión
document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (link && (link.href.includes('/logout') || link.href.includes('/logout'))) {
        resetSessionCounter();
    }
});

// Detectar cuando se envía un formulario de cierre de sesión
document.addEventListener('submit', function(e) {
    const form = e.target.closest('form');
    if (form && (form.action.includes('/logout') || form.action.includes('/logout'))) {
        resetSessionCounter();
    }
});

// Limpiar contador al cerrar la pestaña o navegador
window.addEventListener('beforeunload', function() {
    // El contador se reiniciará automáticamente en la próxima visita
    // ya que localStorage.removeItem('sessionStartTime') se llama en los eventos de logout
});
</script>
@endsection
