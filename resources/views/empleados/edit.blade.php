@extends('layouts.app')

@php
use Illuminate\Support\Js;
@endphp

@section('content')
    <!-- Mensaje de error de validación -->
    @if ($errors->any())
        <div id="alert" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L9.586 10l-2.293 2.293a1 1 0 101.414 1.414L11 11.414l2.293 2.293a1 1 0 001.414-1.414L12.414 10l2.293-2.293a1 1 0 00-1.414-1.414L11 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">¡Error de validación!</h3>
                    <div class="mt-2 text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('alert');
                if (alert) alert.style.display = 'none';
            }, 5000);
        </script>
    @endif

    <!-- Contenedor principal -->
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Encabezado y botón de acción -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('empleados.index') }}" class="inline-flex items-center justify-center h-8 w-8 rounded-md border border-gray-300 bg-white text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m11 17-5-5 5-5"></path>
                        <path d="M6 12h14"></path>
                    </svg>
                </a>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Modificar Empleado</h1>
            </div>
            <button type="submit" form="empleado-form" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-slate-800 hover:bg-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Actualizar
            </button>
        </div>
        <!-- Formulario -->
    
        <form id="empleado-form" action="{{ route('empleados.update', $empleado) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Componente Alpine.js para tabs y datos -->
            <div x-data="{
                    activeTab: 'personal',
                    patologias: {{ Js::from(old('patologias', $patologias ?? [])) }},
                    beneficiarios: {{ Js::from(old('beneficiarios', $beneficiarios ?? [])) }}
                }">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <!-- Foto de perfil (solo visual) -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            <!-- Contenedor de la foto -->
                            <div class="w-36 h-36 rounded-lg overflow-hidden border border-gray-200 shadow-sm flex-shrink-0">                      
                                    <div id="foto-placeholder" class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                            </div>
                            <!-- Información de la foto -->
                            <div class="flex-1 w-full">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto de perfil</label>
                                <p class="text-sm text-gray-500">La funcionalidad de carga de fotos está temporalmente deshabilitada.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navegación de pestañas -->
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px overflow-x-auto">
                            <button type="button" @click="activeTab = 'personal'" :class="{'border-slate-800 text-slate-800': activeTab === 'personal', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'personal'}" class="py-4 px-6 border-b-2 font-medium text-sm">
                                Información Personal
                            </button>
                            <button type="button" @click="activeTab = 'ubicacion'" :class="{'border-slate-800 text-slate-800': activeTab === 'ubicacion', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'ubicacion'}" class="py-4 px-6 border-b-2 font-medium text-sm">
                                Ubicación
                            </button>
                            <button type="button" @click="activeTab = 'laboral'" :class="{'border-slate-800 text-slate-800': activeTab === 'laboral', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'laboral'}" class="py-4 px-6 border-b-2 font-medium text-sm">
                                Información Laboral
                            </button>
                            <button type="button" @click="activeTab = 'adicional'" :class="{'border-slate-800 text-slate-800': activeTab === 'adicional', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'adicional'}" class="py-4 px-6 border-b-2 font-medium text-sm">
                         
                         
                            Datos Adicionales
                            </button>
                        </nav>
                    </div>

                    <!-- Contenido de las pestañas -->
                    <div>
                        <!-- Información Personal -->
                        <div x-show="activeTab === 'personal'" class="space-y-6">
                            <br>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nombre_completo" class="block text-sm font-medium text-gray-700">
                                        Nombre Completo <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nombre_completo" id="nombre_completo" value="{{ old('nombre_completo', $empleado->nombre_completo) }}" 
                                           class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">
                                        Fecha de Nacimiento <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento ? $empleado->fecha_nacimiento->format('Y-m-d') : '') }}" 
                                           class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">
                                        Tipo de Documento <span class="text-red-500">*</span>
                                    </label>
                                    <select name="tipo_documento_id" id="tipo_documento_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione tipo de documento</option>
                                        @foreach($tiposDocumento as $tipo)
                                            <option value="{{ $tipo->id_tipo_documento }}" {{ old('tipo_documento_id', $empleado->tipo_documento_id) == $tipo->id_tipo_documento ? 'selected' : '' }}>
                                                {{ $tipo->nombre_tipo_documento }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="numero_documento" class="block text-sm font-medium text-gray-700">
                                        Número de Documento <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento', $empleado->numero_documento) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="sexo" class="block text-sm font-medium text-gray-700">
                                        Genero <span class="text-red-500">*</span>
                                    </label>
                                    <select name="sexo" id="sexo" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione sexo</option>
                                        <option value="MASCULINO" {{ old('sexo', $empleado->sexo) == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                                        <option value="FEMENINO" {{ old('sexo', $empleado->sexo) == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                                        <option value="OTRO" {{ old('sexo', $empleado->sexo) == 'OTRO' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="estado_civil" class="block text-sm font-medium text-gray-700">
                                        Estado Civil <span class="text-red-500">*</span>
                                    </label>
                                    <select name="estado_civil" id="estado_civil" 
                                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione estado civil</option>
                                        <option value="Soltero(a)" {{ old('estado_civil', $empleado->estado_civil) == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                        <option value="Casado(a)" {{ old('estado_civil', $empleado->estado_civil) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                        <option value="Union Libre" {{ old('estado_civil', $empleado->estado_civil) == 'Union Libre' ? 'selected' : '' }}>Union Libre</option>
                                        <option value="Viudo(a)" {{ old('estado_civil', $empleado->estado_civil) == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                                        <option value="Divorciado(a)" {{ old('estado_civil', $empleado->estado_civil) == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="nivel_educativo" class="block text-sm font-medium text-gray-700">
                                        Nivel Educativo <span class="text-red-500">*</span>
                                    </label>
                                    <select name="nivel_educativo" id="nivel_educativo" 
                                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione nivel educativo</option>
                                        <option value="Primaria" {{ old('nivel_educativo', $empleado->nivel_educativo) == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                                        <option value="Secundaria" {{ old('nivel_educativo', $empleado->nivel_educativo) == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                                        <option value="Técnico" {{ old('nivel_educativo', $empleado->nivel_educativo) == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                                        <option value="Tecnólogo" {{ old('nivel_educativo', $empleado->nivel_educativo) == 'Tecnólogo' ? 'selected' : '' }}>Tecnólogo</option>
                                        <option value="Profesional" {{ old('nivel_educativo', $empleado->nivel_educativo) == 'Profesional' ? 'selected' : '' }}>Profesional</option>
                                        <option value="Especialización" {{ old('nivel_educativo', $empleado->nivel_educativo) == 'Especialización' ? 'selected' : '' }}>Especialización</option>
                                        <option value="Maestría" {{ old('nivel_educativo', $empleado->nivel_educativo) == 'Maestría' ? 'selected' : '' }}>Maestría</option>
                                        <option value="Doctorado" {{ old('nivel_educativo', $empleado->nivel_educativo) == 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="rango_edad_id" class="block text-sm font-medium text-gray-700">
                                        Rango de Edad <span class="text-red-500">*</span>
                                    </label>
                                    <select name="rango_edad_id" id="rango_edad_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione rango de edad</option>
                                        @foreach($rangosEdad as $rango)
                                            <option value="{{ $rango->id_rango }}" {{ old('rango_edad_id', $empleado->rango_edad_id) == $rango->id_rango ? 'selected' : '' }}>
                                                {{ $rango->nombre_rango }} ({{ $rango->edad_minima }} - {{ $rango->edad_maxima }} años)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Grupo Sanguíneo (RH) -->
                                <div>
                                    <label for="grupo_sanguineo_id" class="block text-sm font-medium text-gray-700">Grupo Sanguíneo (RH)</label>
                                    <select name="grupo_sanguineo_id" id="grupo_sanguineo_id"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione</option>
                                        @foreach ($gruposSanguineos as $grupo)
                                            <option value="{{ $grupo->id }}" {{ old('grupo_sanguineo_id', $empleado->grupo_sanguineo_id) == $grupo->id ? 'selected' : '' }}>
                                                {{ $grupo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Etnia -->
                                <div>
                                    <label for="etnia_id" class="block text-sm font-medium text-gray-700">Etnia</label>
                                    <select name="etnia_id" id="etnia_id"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione</option>
                                        @foreach ($etnias as $etnia)
                                            <option value="{{ $etnia->id }}" {{ old('etnia_id', $empleado->etnia_id) == $etnia->id ? 'selected' : '' }}>
                                                {{ $etnia->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- ¿Es Padre o Madre? -->
                                <div>
                                    <label for="padre_o_madre" class="block text-sm font-medium text-gray-700">¿Es padre o madre?</label>
                                    <select name="padre_o_madre" id="padre_o_madre" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione</option>
                                        <option value="1" {{ old('padre_o_madre', $empleado->padre_o_madre) == '1' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ old('padre_o_madre', $empleado->padre_o_madre) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <!-- Tipo de Vivienda -->
                                <div>
                                    <label for="tipo_vivienda" class="block text-sm font-medium text-gray-700">Tipo de Vivienda</label>
                                    <input type="text" name="tipo_vivienda" id="tipo_vivienda" value="{{ old('tipo_vivienda', $empleado->tipo_vivienda) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>

                                <!-- Estrato -->
                                <div>
                                    <label for="estrato" class="block text-sm font-medium text-gray-700">Estrato</label>
                                    <input type="number" name="estrato" id="estrato" value="{{ old('estrato', $empleado->estrato) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>

                                <!-- ¿Tiene Vehículo Propio? -->
                                <div>
                                    <label for="vehiculo_propio" class="block text-sm font-medium text-gray-700">¿Posee vehículo propio?</label>
                                    <select name="vehiculo_propio" id="vehiculo_propio"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione</option>
                                        <option value="1" {{ old('vehiculo_propio', $empleado->vehiculo_propio) == 1 ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ old('vehiculo_propio', $empleado->vehiculo_propio) === 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <!-- Tipo de Vehículo -->
                                <div>
                                    <label for="tipo_vehiculo" class="block text-sm font-medium text-gray-700">Tipo de Vehículo</label>
                                    <input type="text" name="tipo_vehiculo" id="tipo_vehiculo"
                                        value="{{ old('tipo_vehiculo', $empleado->tipo_vehiculo) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>

                                <!-- Movilidad -->
                                <div>
                                    <label for="movilidad" class="block text-sm font-medium text-gray-700">Movilidad</label>
                                    <input type="text" name="movilidad" id="movilidad"
                                        value="{{ old('movilidad', $empleado->movilidad) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>

                                <!-- Institución Educativa -->
                                <div>
                                    <label for="institucion_educativa" class="block text-sm font-medium text-gray-700">Institución Educativa</label>
                                    <input type="text" name="institucion_educativa" id="institucion_educativa"
                                        value="{{ old('institucion_educativa', $empleado->institucion_educativa) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>

                                <!-- Intereses Personales -->
                                <div>
                                    <label for="intereses_personales" class="block text-sm font-medium text-gray-700">Intereses Personales</label>
                                    <input type="text" name="intereses_personales" id="intereses_personales"
                                        value="{{ old('intereses_personales', $empleado->intereses_personales) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>
                                
                                <!-- Idiomas -->
                                <div>
                                    <label for="idiomas" class="block text-sm font-medium text-gray-700">Idiomas</label>
                                    <input type="text" name="idiomas" id="idiomas"
                                        value="{{ old('idiomas', $empleado->idiomas) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>
                            </div>

                            <hr class="my-6 border-gray-200">
                            <!-- Patologías -->
                           <div>
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Patologías</h3>
                                    <button type="button" @click="patologias.push({})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-slate-800 hover:bg-slate-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Agregar
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <script>
                                        window.patologiasOld = @json(old('patologias', $patologias ?? []));
                                    </script>

                                    <div x-data="{ patologias: window.patologiasOld }">
                                        <template x-for="(item, index) in patologias" :key="index">
                                            <div class="bg-gray-50 rounded-lg p-4 relative">
                                                <button type="button" @click="patologias.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label :for="'patologias['+index+'][nombre_patologia]'" class="block text-sm font-medium text-gray-700">Nombre de la Patología</label>
                                                        <input type="text" x-model="item.nombre_patologia" :name="'patologias['+index+'][nombre_patologia]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Nombre de la patología">
                                                    </div>

                                                    <div>
                                                        <label :for="'patologias['+index+'][fecha_diagnostico]'" class="block text-sm font-medium text-gray-700">Fecha de Diagnóstico</label>
                                                        <input type="date" x-model="item.fecha_diagnostico" :name="'patologias['+index+'][fecha_diagnostico]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                                    </div>

                                                    <div>
                                                        <label :for="'patologias['+index+'][gravedad_patologia]'" class="block text-sm font-medium text-gray-700">Gravedad</label>
                                                        <select x-model="item.gravedad_patologia" :name="'patologias['+index+'][gravedad_patologia]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                                            <option value="">Seleccione gravedad</option>
                                                            <option value="Leve">Leve</option>
                                                            <option value="Moderada">Moderada</option>
                                                            <option value="Grave">Grave</option>
                                                            <option value="Muy Grave">Muy Grave</option>
                                                        </select>
                                                    </div>

                                                    <div class="md:col-span-2">
                                                        <label :for="'patologias['+index+'][descripcion_patologia]'" class="block text-sm font-medium text-gray-700">Descripción</label>
                                                        <textarea x-model="item.descripcion_patologia" :name="'patologias['+index+'][descripcion_patologia]'" rows="3" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Descripción de la patología"></textarea>
                                                    </div>

                                                    <div class="md:col-span-2">
                                                        <label :for="'patologias['+index+'][tratamiento_actual_patologia]'" class="block text-sm font-medium text-gray-700">Tratamiento Actual</label>
                                                        <textarea x-model="item.tratamiento_actual_patologia" :name="'patologias['+index+'][tratamiento_actual_patologia]'" rows="3" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Tratamiento actual"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <div x-show="patologias.length === 0" class="text-center py-4 text-sm text-gray-500">
                                        No se han agregado patologías
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ubicación -->
                            <div x-show="activeTab === 'ubicacion'" class="space-y-6">
                                <!-- Lugar de Nacimiento -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Lugar de Nacimiento</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- País -->
                                        <div>
                                            <label for="pais_id_nacimiento" class="block text-sm font-medium text-gray-700">País <span class="text-red-500">*</span>
                                            </label>
                                            <select name="pais_id_nacimiento" id="pais_id_nacimiento"class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"required>
                                                <option value="">Seleccione país</option>
                                                @foreach($paises as $pais)
                                                    <option value="{{ $pais->id_pais }}"
                                                        {{ old('pais_id_nacimiento', optional($empleado->nacimiento)->pais_id) == $pais->id_pais ? 'selected' : '' }}>
                                                        {{ $pais->nombre_pais }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Departamento -->
                                        <div>
                                            <label for="departamento_id_nacimiento" class="block text-sm font-medium text-gray-700">
                                                Departamento <span class="text-red-500">*</span>
                                            </label>
                                            <select name="departamento_id_nacimiento" id="departamento_id_nacimiento" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                                <option value="">Seleccione departamento</option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{ $departamento->id_departamento }}"
                                                        {{ old('departamento_id_nacimiento', optional($empleado->nacimiento)->departamento_id) == $departamento->id_departamento ? 'selected' : '' }}>
                                                        {{ $departamento->nombre_departamento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Municipio -->
                                        <div>
                                            <label for="municipio_id_nacimiento" class="block text-sm font-medium text-gray-700">
                                                Municipio <span class="text-red-500">*</span>
                                            </label>
                                            <select name="municipio_id_nacimiento" id="municipio_id_nacimiento" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                                <option value="">Seleccione municipio</option>
                                                @foreach($municipios as $municipio)
                                                    <option value="{{ $municipio->id_municipio }}"
                                                        {{ old('municipio_id_nacimiento', optional($empleado->nacimiento)->municipio_id) == $municipio->id_municipio ? 'selected' : '' }}>
                                                        {{ $municipio->nombre_municipio }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-6 border-gray-300">
                                <!-- Lugar de Residencia -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Lugar de Residencia</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- País -->
                                        <div>
                                            <label for="pais_id_residencia" class="block text-sm font-medium text-gray-700">
                                                País <span class="text-red-500">*</span>
                                            </label>
                                            <select name="pais_id_residencia" id="pais_id_residencia"
                                                    class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"required>
                                                <option value="">Seleccione país</option>
                                                @foreach($paises as $pais)
                                                    <option value="{{ $pais->id_pais }}"
                                                        {{ old('pais_id_residencia', optional($empleado->residencia)->pais_id) == $pais->id_pais ? 'selected' : '' }}>
                                                        {{ $pais->nombre_pais }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Departamento -->
                                        <div>
                                            <label for="departamento_id_residencia" class="block text-sm font-medium text-gray-700">
                                                Departamento <span class="text-red-500">*</span>
                                            </label>
                                            <select name="departamento_id_residencia" id="departamento_id_residencia"
                                                    class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                                    required>
                                                <option value="">Seleccione departamento</option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{ $departamento->id_departamento }}"
                                                        {{ old('departamento_id_residencia', optional($empleado->residencia)->departamento_id) == $departamento->id_departamento ? 'selected' : '' }}>
                                                        {{ $departamento->nombre_departamento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Municipio -->
                                        <div>
                                            <label for="municipio_id_residencia" class="block text-sm font-medium text-gray-700">
                                                Municipio <span class="text-red-500">*</span>
                                            </label>
                                            <select name="municipio_id_residencia" id="municipio_id_residencia"
                                                    class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                                    required>
                                                <option value="">Seleccione municipio</option>
                                                @foreach($municipios as $municipio)
                                                    <option value="{{ $municipio->id_municipio }}"
                                                        {{ old('municipio_id_residencia', optional($empleado->residencia)->municipio_id) == $municipio->id_municipio ? 'selected' : '' }}>
                                                        {{ $municipio->nombre_municipio }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Barrio -->
                                        <div>
                                            <label for="barrio_id_residencia" class="block text-sm font-medium text-gray-700">Barrio <span class="text-red-500">*</span></label>
                                            <select name="barrio_id_residencia" id="barrio_id_residencia"
                                                    class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"required>
                                                <option value="">Seleccione barrio</option>
                                                @foreach($barrios as $barrio)
                                                    <option value="{{ $barrio->id_barrio }}"
                                                        {{ old('barrio_id_residencia', optional($empleado->residencia)->barrio_id) == $barrio->id_barrio ? 'selected' : '' }}>
                                                        {{ $barrio->nombre_barrio }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Dirección, Teléfono, Email -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                        <div>
                                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                                            <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $empleado->direccion) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Dirección de residencia">
                                        </div>

                                        <div>
                                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $empleado->telefono) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Número de teléfono">
                                        </div>
                                        <!-- Teléfono fijo -->
                                        <div>
                                            <label for="telefono_fijo" class="block text-sm font-medium text-gray-700">Teléfono Fijo</label>
                                            <input type="text" name="telefono_fijo" id="telefono_fijo" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"value="{{ old('telefono_fijo', $informacionLaboral->telefono_fijo ?? '') }}">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                            <input type="email" name="email" id="email" value="{{ old('email', $empleado->email) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"placeholder="correo@ejemplo.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div x-show="activeTab === 'laboral'" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="empresa_id" class="block text-sm font-medium text-gray-700">
                                        Empresa <span class="text-red-500">*</span>
                                    </label>
                                    <select name="empresa_id" id="empresa_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione empresa</option>
                                        @foreach($empresas as $empresa)
                                            <option value="{{ $empresa->id_empresa }}" {{ old('empresa_id', $empleado->informacionLaboral->first()?->empresa_id) == $empresa->id_empresa ? 'selected' : '' }}>
                                                {{ $empresa->nombre_empresa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="cargo_id" class="block text-sm font-medium text-gray-700">
                                        Cargo <span class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $cargo = optional($empleado->informacionLaboralActual?->estadoCargo)->cargo ?? null;
                                    @endphp

                                    <select name="cargo_id" id="cargo_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        @foreach($cargos as $c)
                                            <option value="{{ $c->id_cargo }}"
                                                {{ old('cargo_id', $cargo?->id_cargo) == $c->id_cargo ? 'selected' : '' }}>
                                                {{ $c->nombre_cargo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">
                                        Fecha de Ingreso <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso', $empleado->informacionLaboral->first()?->fecha_ingreso?->format('Y-m-d')) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="fecha_salida" class="block text-sm font-medium text-gray-700">
                                        Fecha de Salida
                                    </label>
                                    <input type="date" name="fecha_salida" id="fecha_salida" value="{{ old('fecha_salida', $empleado->informacionLaboral->first()?->fecha_salida?->format('Y-m-d')) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>
                                <div>
                                    <label for="tipo_contrato" class="block text-sm font-medium text-gray-700">Tipo de Contrato</label>
                                    <select name="tipo_contrato" id="tipo_contrato"
                                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione tipo de contrato</option>
                                        <option value="Indefinido" {{ old('tipo_contrato', $empleado->informacionLaboral->first()?->tipo_contrato) == 'Indefinido' ? 'selected' : '' }}>Indefinido</option>
                                        <option value="Fijo" {{ old('tipo_contrato', $empleado->informacionLaboral->first()?->tipo_contrato) == 'Fijo' ? 'selected' : '' }}>Término Fijo</option>
                                        <option value="Obra Labor" {{ old('tipo_contrato', $empleado->informacionLaboral->first()?->tipo_contrato) == 'Obra Labor' ? 'selected' : '' }}>Obra o Labor</option>
                                        <option value="Prestación de Servicios" {{ old('tipo_contrato', $empleado->informacionLaboral->first()?->tipo_contrato) == 'Prestación de Servicios' ? 'selected' : '' }}>Prestación de Servicios</option>
                                        <option value="Aprendizaje" {{ old('tipo_contrato', $empleado->informacionLaboral->first()?->tipo_contrato) == 'Aprendizaje' ? 'selected' : '' }}>Aprendizaje</option>
                                    </select>
                                </div>
                                 <!-- EPS -->
                                <div>
                                    <label for="eps_id">EPS</label>
                                    <select name="eps_id" id="eps_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione EPS</option>
                                        @foreach($eps as $e)
                                            <option value="{{ $e->id }}" {{ old('eps_id', $empleado->eps_id) == $e->id ? 'selected' : '' }}>
                                                {{ $e->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- AFP -->
                                <div>
                                    <label for="afp_id">AFP</label>
                                    <select name="afp_id" id="afp_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione AFP</option>
                                        @foreach($afp as $a)
                                            <option value="{{ $a->id }}" {{ old('afp_id', $empleado->afp_id) == $a->id ? 'selected' : '' }}>
                                                {{ $a->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- ARL -->
                                <div>
                                    <label for="arl_id" class="block text-sm font-medium text-gray-700">ARL</label>
                                    <select name="arl_id" id="arl_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione ARL</option>
                                        @foreach($arl as $a)
                                            <option value="{{ $a->id }}" {{ old('arl_id', $empleado->arl_id) == $a->id ? 'selected' : '' }}>
                                                {{ $a->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Dotación -->
                                <div>
                                    <label for="aplica_dotacion" class="block text-sm font-medium text-gray-700">¿Necesita Dotación?</label>
                                    <select name="aplica_dotacion" id="aplica_dotacion" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none appearance-none">
                                        <option value="">Seleccione</option>
                                        <option value="1" {{ old('aplica_dotacion', $empleado->aplica_dotacion) == 1 ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ old('aplica_dotacion', $empleado->aplica_dotacion) == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <!-- Caja de Compensación -->
                                <div>
                                    <label for="ccf_id">Caja de Compensación</label>
                                    <select name="ccf_id" id="ccf_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione Caja de Compensación</option>
                                        @foreach($ccf as $c)
                                            <option value="{{ $c->id }}" {{ old('ccf_id', $empleado->ccf_id) == $c->id ? 'selected' : '' }}>
                                                {{ $c->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- Ciudad Laboral -->
                                <div class="mb-4">
                                    <label for="ciudad_laboral_id">Ciudad donde labora</label>
                                    <select name="ciudad_laboral_id" id="ciudad_laboral_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione una ciudad</option>
                                        @foreach($ciudades as $ciudad)
                                            <option value="{{ $ciudad->id }}" {{ old('ciudad_laboral_id', optional($empleado->informacionLaboralActual)->ciudad_laboral_id) == $ciudad->id ? 'selected' : '' }}>
                                                {{ $ciudad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Talla Camisa -->
                                <div class="mb-4">
                                    <label for="talla_camisa" class="block text-sm font-medium text-gray-700">Talla de camisa</label>
                                    <input type="text" name="talla_camisa" id="talla_camisa"
                                        value="{{ old('talla_camisa', optional($empleado->informacionLaboralActual)->talla_camisa) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                        placeholder="Ej. M, L, XL">
                                </div>

                                <!-- Talla pantalón -->
                                <div class="mb-4">
                                    <label for="talla_pantalon" class="block text-sm font-medium text-gray-700">Talla de pantalón</label>
                                    <input type="text" name="talla_pantalon" id="talla_pantalon"
                                        value="{{ old('talla_pantalon', optional($empleado->informacionLaboralActual)->talla_pantalon) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                        placeholder="Ej. 32, 34">
                                </div>

                                <!-- Talla zapatos -->
                                <div class="mb-4">
                                    <label for="talla_zapatos" class="block text-sm font-medium text-gray-700">Talla de zapatos</label>
                                    <input type="text" name="talla_zapatos" id="talla_zapatos"
                                        value="{{ old('talla_zapatos', optional($empleado->informacionLaboralActual)->talla_zapatos) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                        placeholder="Ej. 38, 40">
                                </div>
                                 <div>
                                    <label for="tipo_vinculacion" class="block text-sm font-medium text-gray-700">Tipo de vinculación</label> 
                                    <select name="tipo_vinculacion" id="tipo_vinculacion" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Tipo de vinculación</option>
                                        <option value="Directo" {{ old('tipo_vinculacion', $informacionLaboral->tipo_vinculacion) == 'Directo' ? 'selected' : '' }}>Directo</option>
                                        <option value="Indirecto" {{ old('tipo_vinculacion', $informacionLaboral->tipo_vinculacion) == 'Indirecto' ? 'selected' : '' }}>Indirecto</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="relacion_sindical" class="block text-sm font-medium text-gray-700">¿Tiene relación sindical?</label>
                                    <select name="relacion_sindical" id="relacion_sindical" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione</option>
                                        <option value="1" {{ old('relacion_sindical', $empleado->informacionLaboralActual->relacion_sindical ?? '') == 'SI' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ old('relacion_sindical', $empleado->informacionLaboralActual->relacion_sindical ?? '') == 'NO' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <!-- Relación Laboral -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Relación laboral</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @php
                                                $opciones = ['Ley 50', 'Salario Integral', 'Sin ninguna prestación'];
                                                // Esta línea está perfecta
                                                $seleccionadas = old('informacion_laboral.relacion_laboral', explode(',', $informacionLaboral->relacion_laboral ?? ''));
                                            @endphp

                                            @foreach ($opciones as $opcion)
                                                <label class="flex items-center space-x-2 text-sm text-gray-700 bg-gray-100 px-4 py-2 rounded-md shadow-sm">
                                                    <input
                                                        type="checkbox"
                                                        name="informacion_laboral[relacion_laboral][]"
                                                        value="{{ $opcion }}"
                                                        @checked(in_array($opcion, $seleccionadas))
                                                        class="text-pink-600 focus:ring-pink-500 border-gray-300 rounded"
                                                    />
                                                    <span>{{ $opcion }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>               
                                </div>
                            </div>
                       <!-- Datos Adicionales -->
                            <div x-show="activeTab === 'adicional'" class="space-y-6">
                                <!-- Beneficiarios -->
                                <script>
                                    window.__beneficiarios = @json(old('beneficiarios', $beneficiarios ?? []));

                                    function beneficiariosForm() {
                                        return {
                                            beneficiarios: [],
                                            init() {
                                                // Inicializar con los beneficiarios del empleado o los valores de old()
                                                this.beneficiarios = window.__beneficiarios.length > 0 ? 
                                                    window.__beneficiarios.map(b => ({
                                                        ...b,
                                                        tipo_union: b.tipo_union || ''
                                                    })) : [];
                                                console.log('Beneficiarios cargados:', this.beneficiarios);
                                            },
                                            agregar() {
                                                this.beneficiarios.push({
                                                    nombre_beneficiario: '',
                                                    parentesco: '',
                                                    fecha_nacimiento: '',
                                                    tipo_documento_id: '',
                                                    numero_documento: '',
                                                    nivel_educativo: '',
                                                    tipo_union: '',
                                                    // Campos para archivos
                                                    registro_nacimiento: null,
                                                    certificado_escolar: null,
                                                    eps_hijo: null,
                                                    eps_padre_madre: null,
                                                    registro_matrimonio: null,
                                                    cedula_conyuge: null,
                                                    declaracion_union: null,
                                                    cedula_companero: null
                                                });
                                            },
                                            eliminar(index) {
                                                this.beneficiarios.splice(index, 1);
                                            },
                                            // Función para manejar la carga de archivos
                                            handleFileUpload(event, index, field) {
                                                const file = event.target.files[0];
                                                if (file) {
                                                    this.beneficiarios[index][field] = file;
                                                }
                                            }
                                        };
                                    }
                                </script>
                                <div x-data="beneficiariosForm()" x-init="init()">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">Beneficiarios</h3>
                                        <button type="button" @click="agregar()" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-slate-800 hover:bg-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="space-y-4">
                                        <template x-for="(item, index) in beneficiarios" :key="index">
                                            <div class="bg-gray-50 rounded-lg p-4 relative">
                                                <button type="button" @click="eliminar(index)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Nombre Completo <span class="text-red-500">*</span></label>
                                                        <input type="text" x-model="item.nombre_beneficiario" :name="'beneficiarios['+index+'][nombre_beneficiario]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Nombre del beneficiario" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Parentesco <span class="text-red-500">*</span></label>
                                                        <select x-model="item.parentesco" :name="'beneficiarios['+index+'][parentesco]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                                            <option value="">Seleccione parentesco</option>
                                                            <option value="Cónyuge">Cónyuge</option>
                                                            <option value="Hijo/a">Hijo/a</option>
                                                            <option value="Padre">Padre</option>
                                                            <option value="Madre">Madre</option>
                                                            <option value="Hermano/a">Hermano/a</option>
                                                            <option value="Otro">Otro</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                                                        <input type="date" x-model="item.fecha_nacimiento" :name="'beneficiarios['+index+'][fecha_nacimiento]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                                                        <select x-model="item.tipo_documento_id" :name="'beneficiarios['+index+'][tipo_documento_id]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                                            <option value="">Seleccione tipo</option>
                                                            @foreach($tiposDocumento as $tipo)
                                                                <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->nombre_tipo_documento }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Número de Documento</label>
                                                        <input type="text" x-model="item.numero_documento" :name="'beneficiarios['+index+'][numero_documento]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Número de documento">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Nivel Educativo</label>
                                                        <select x-model="item.nivel_educativo" :name="'beneficiarios['+index+'][nivel_educativo]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                                            <option value="">Seleccione nivel</option>
                                                            <option value="Primaria">Primaria</option>
                                                            <option value="Secundaria">Secundaria</option>
                                                            <option value="Bachillerato">Bachillerato</option>
                                                            <option value="Técnico">Técnico</option>
                                                            <option value="Tecnológico">Tecnológico</option>
                                                            <option value="Universitario">Universitario</option>
                                                            <option value="Posgrado">Posgrado</option>
                                                        </select>
                                                    </div>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                        <!-- ¿Reside con el empleado? -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">¿Reside con el trabajador?</label>
                                                            <select :name="'beneficiarios[' + index + '][reside_con_empleado]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                                                x-model="item.reside_con_empleado">
                                                                <option value="1">Sí</option>
                                                                <option value="0">No</option>
                                                            </select>
                                                        </div>

                                                        <!-- ¿Depende económicamente? -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">¿Depende económicamente?</label>
                                                            <select :name="'beneficiarios[' + index + '][depende_economicamente]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                                                x-model="item.depende_economicamente">
                                                                <option value="1">Sí</option>
                                                                <option value="0">No</option>
                                                            </select>
                                                        </div>

                                                        <!-- Contacto de emergencia -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Contacto de emergencia</label>
                                                            <input type="text" x-model="beneficiarios[index].contacto_emergencia" :name="'beneficiarios[' + index + '][contacto_emergencia]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <div class="bg-white border border-gray-200 rounded-xl shadow p-6 mb-6 mt-6">
                                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Documentación General del Empleado</h2> 
                                    <!-- Campo único para subir documento -->
                                    <div class="mb-8">
                                        <h3 class="text-md font-medium text-gray-700 mb-4 border-b pb-2">1. Documento Principal</h3>

                                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-200">
                                            <div class="flex items-center gap-4 mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span class="text-base font-medium text-gray-700">Documento principal</span>
                                            </div>
                                            <input type="file" name="documento_principal" id="documento_principal" class="block w-full text-base text-gray-800 file:mr-6 file:py-4 file:px-8 file:rounded-md file:border-0 file:text-base file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 focus:outline-none focus:ring-2 focus:ring-sky-500 transition" />
                                            <p class="mt-4 text-sm text-gray-500">Solo PDF, JPG o PNG. Máx 5MB.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Para Lugar de Nacimiento
    const paisSelectNacimiento = document.getElementById('pais_id_nacimiento');
    const departamentoSelectNacimiento = document.getElementById('departamento_id_nacimiento');
    const municipioSelectNacimiento = document.getElementById('municipio_id_nacimiento');
    
    if (paisSelectNacimiento) {
        paisSelectNacimiento.addEventListener('change', function() {
            const paisId = this.value;
            departamentoSelectNacimiento.innerHTML = '<option value="">Cargando...</option>';
            municipioSelectNacimiento.innerHTML = '<option value="">Seleccione municipio</option>';

            fetch(`{{ url('/api/departamentos') }}/${paisId}`)
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">Seleccione departamento</option>';
                    data.forEach(dep => {
                        options += `<option value="${dep.id_departamento}">${dep.nombre_departamento}</option>`;
                    });
                    departamentoSelectNacimiento.innerHTML = options;
                })
                .catch(() => {
                    departamentoSelectNacimiento.innerHTML = '<option value="">Error al cargar departamentos</option>';
                });
        });
    }

    if (departamentoSelectNacimiento) {
        departamentoSelectNacimiento.addEventListener('change', function() {
            const departamentoId = this.value;
            municipioSelectNacimiento.innerHTML = '<option value="">Cargando...</option>';

            fetch(`{{ url('/api/municipios') }}/${departamentoId}`)
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">Seleccione municipio</option>';
                    data.forEach(mun => {
                        options += `<option value="${mun.id_municipio}">${mun.nombre_municipio}</option>`;
                    });
                    municipioSelectNacimiento.innerHTML = options;
                })
                .catch(() => {
                    municipioSelectNacimiento.innerHTML = '<option value="">Error al cargar municipios</option>';
                });
        });
    }

    // Para Lugar de Residencia
    const paisSelectResidencia = document.getElementById('pais_id_residencia');
    const departamentoSelectResidencia = document.getElementById('departamento_id_residencia');
    const municipioSelectResidencia = document.getElementById('municipio_id_residencia');
    const barrioSelectResidencia = document.getElementById('barrio_id_residencia');

    paisSelectResidencia?.addEventListener('change', function() {
        const paisId = this.value;
        departamentoSelectResidencia.innerHTML = '<option value="">Cargando...</option>';
        municipioSelectResidencia.innerHTML = '<option value="">Seleccione municipio</option>';

        fetch(`{{ url('/api/departamentos') }}/${paisId}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Seleccione departamento</option>';
                data.forEach(dep => {
                    options += `<option value="${dep.id_departamento}">${dep.nombre_departamento}</option>`;
                });
                departamentoSelectResidencia.innerHTML = options;
            });
    });

    departamentoSelectResidencia?.addEventListener('change', function() {
        const departamentoId = this.value;
        municipioSelectResidencia.innerHTML = '<option value="">Cargando...</option>';

        fetch(`{{ url('/api/municipios') }}/${departamentoId}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Seleccione municipio</option>';
                data.forEach(mun => {
                    options += `<option value="${mun.id_municipio}">${mun.nombre_municipio}</option>`;
                });
                municipioSelectResidencia.innerHTML = options;
            });
    });

    municipioSelectResidencia?.addEventListener('change', function() {
        const municipioId = this.value;
        barrioSelectResidencia.innerHTML = '<option value="">Cargando barrios...</option>';
        
        if (municipioId) {
            fetch(`{{ url('/api/barrios') }}/${municipioId}`)
                .then(res => res.json())
                .then(barrios => {
                    let options = '<option value="">Seleccione barrio</option>';
                    barrios.forEach(barrio => {
                        options += `<option value="${barrio.id_barrio}">${barrio.nombre_barrio}</option>`;
                    });
                    barrioSelectResidencia.innerHTML = options;
                })
                .catch(() => {
                    barrioSelectResidencia.innerHTML = '<option value="">Error al cargar barrios</option>';
                });
        } else {
            barrioSelectResidencia.innerHTML = '<option value="">Seleccione un municipio primero</option>';
        }
    });

    // Para Información Laboral → Empresa → Cargo
    const empresaSelect = document.getElementById('empresa_id');
    const cargoSelect   = document.getElementById('cargo_id');

    empresaSelect?.addEventListener('change', function() {
        const empresaId = this.value;
        cargoSelect.innerHTML = '<option value="">Cargando cargos...</option>';
        cargoSelect.disabled = true;

        if (empresaId) {
            fetch(`{{ url('/api/cargos') }}/${empresaId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Error en la petición');
                    return res.json();
                })
                .then(cargos => {
                    let options = '<option value="">Seleccione cargo</option>';
                    cargos.forEach(cargo => {
                        options += `<option value="${cargo.id_cargo}">${cargo.nombre_cargo}</option>`;
                    });
                    cargoSelect.innerHTML = options;
                    cargoSelect.disabled = false;

                    // Mantener valor previo (en caso de validación fallida)
                    const oldValue = "{{ old('cargo_id') }}";
                    if (oldValue) {
                        cargoSelect.value = oldValue;
                    }
                })
                .catch(() => {
                    cargoSelect.innerHTML = '<option value="">Selecciona Cargo</option>';
                    cargoSelect.disabled = false;
                });
        } else {
            cargoSelect.innerHTML = '<option value="">Seleccione empresa primero</option>';
            cargoSelect.disabled = false;
        }
    });

    // Triggers iniciales si hay valores preseleccionados
    if (paisSelectNacimiento?.value) paisSelectNacimiento.dispatchEvent(new Event('change'));
    if (departamentoSelectNacimiento?.value) departamentoSelectNacimiento.dispatchEvent(new Event('change'));

    if (empresaSelect?.value) empresaSelect.dispatchEvent(new Event('change'));
});
</script>

<script>
document.getElementById('empresa_id').addEventListener('change', function() {
    let empresaId = this.value;
    let cargoSelect = document.getElementById('cargo_id');

    cargoSelect.innerHTML = '<option value="">Cargando...</option>';

    if (empresaId) {
        fetch(`/empresas/${empresaId}/cargos`)
            .then(res => res.json())
            .then(data => {
                cargoSelect.innerHTML = '<option value="">Cargando Cargos</option>';
                data.forEach(cargo => {
                    let option = document.createElement('option');
                    option.value = cargo.id_cargo;
                    option.textContent = cargo.nombre_cargo;
                    cargoSelect.appendChild(option);
                });
            })
            .catch(() => {
                cargoSelect.innerHTML = '<option value="">Error cargando cargos</option>';
            });
    } else {
        cargoSelect.innerHTML = '<option value="">Cargando Cargos</option>';
    }
});
</script>
<script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const empresaSelect = document.getElementById('empresa_id');
                                        const cargoSelect = document.getElementById('cargo_id');
                                        const cargoError  = document.getElementById('cargo_error');
                                        let requestSeq = 0; // controla concurrencia de cargas

                                        async function cargarCargos(empresaId, preselectId = null) {
                                            cargoSelect.innerHTML = '<option value="">Selecciona Cargo</option>';
                                            cargoError && (cargoError.style.display = 'none');
                                            if (!empresaId) return;
                                            const currentSeq = ++requestSeq;
                                            try {
                                                const url = "{{ url('/empresas') }}" + "/" + encodeURIComponent(empresaId) + "/cargos";
                                                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                                                if (!res.ok) throw new Error('Error al cargar cargos');
                                                const data = await res.json();
                                                // Ignorar respuestas antiguas si hubo otra solicitud posterior
                                                if (currentSeq !== requestSeq || empresaSelect.value !== String(empresaId)) {
                                                    return;
                                                }
                                                if (!Array.isArray(data) || data.length === 0) {
                                                    const opt = document.createElement('option');
                                                    opt.value = '';
                                                    opt.textContent = 'No hay cargos disponibles';
                                                    opt.disabled = true;
                                                    cargoSelect.appendChild(opt);
                                                    return;
                                                }
                                                data.forEach(c => {
                                                    const opt = document.createElement('option');
                                                    opt.value = c.id_cargo;
                                                    opt.textContent = c.nombre_cargo;
                                                    if (preselectId && String(preselectId) === String(c.id_cargo)) {
                                                        opt.selected = true;
                                                    }
                                                    cargoSelect.appendChild(opt);
                                                });
                                            } catch (e) {
                                                console.error(e);
                                                // Solo mostrar error si esta es la solicitud vigente y no hay opciones cargadas
                                                if (currentSeq === requestSeq && cargoError && cargoSelect.options.length <= 1) {
                                                    cargoError.style.display = '';
                                                }
                                            }
                                        }

                                        empresaSelect.addEventListener('change', function () {
                                            cargarCargos(this.value);
                                        });

                                        const oldEmpresa = "{{ old('empresa_id') }}";
                                        const oldCargo = "{{ old('cargo_id') }}";
                                        if (oldEmpresa) {
                                            cargarCargos(oldEmpresa, oldCargo);
                                        }
                                    });
                                </script>
@endpush