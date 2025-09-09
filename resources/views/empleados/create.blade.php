@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('empleados.index') }}" class="inline-flex items-center justify-center h-8 w-8 rounded-md border border-gray-300 bg-white text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m11 17-5-5 5-5"></path>
                        <path d="M6 12h14"></path>
                    </svg>
                </a>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Agregar Empleado</h1>
            </div>
            <button type="submit" form="empleado-form" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-slate-800 hover:bg-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Guardar
            </button>
        </div>

        <form id="empleado-form" action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div
                x-data="{
                    activeTab: 'personal',
                    patologias: [],
                    beneficiarios: []
                }"
            >
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    
                    
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <nav class="flex border-b border-gray-200 bg-slate-50 text-sm font-medium text-gray-600">
                            <button type="button" @click="activeTab = 'personal'" :class="activeTab === 'personal' ? 'text-slate-800 border-slate-800' : 'border-transparent hover:text-gray-700 hover:border-gray-300'" class="px-6 py-3 border-b-2 transition-all duration-200">Información Personal</button>
                            <button type="button" @click="activeTab = 'ubicacion'" :class="activeTab === 'ubicacion' ? 'text-slate-800 border-slate-800' : 'border-transparent hover:text-gray-700 hover:border-gray-300'" class="px-6 py-3 border-b-2 transition-all duration-200">Ubicación</button>
                            <button type="button" @click="activeTab = 'laboral'" :class="activeTab === 'laboral' ? 'text-slate-800 border-slate-800' : 'border-transparent hover:text-gray-700 hover:border-gray-300'" class="px-6 py-3 border-b-2 transition-all duration-200">Información Laboral</button>
                            <button type="button" @click="activeTab = 'adicional'" :class="activeTab === 'adicional' ? 'text-slate-800 border-slate-800' : 'border-transparent hover:text-gray-700 hover:border-gray-300'" class="px-6 py-3 border-b-2 transition-all duration-200">Datos Adicionales</button>
                        </nav>
                    </div>
                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Información Personal -->
                        <div x-show="activeTab === 'personal'" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nombre_completo" class="block text-sm font-medium text-gray-700">
                                        Nombre Completo <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nombre_completo" id="nombre_completo" value="{{ old('nombre_completo') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">
                                        Fecha de Nacimiento <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">
                                        Tipo de Documento <span class="text-red-500">*</span>
                                    </label>
                                    <select name="tipo_documento_id" id="tipo_documento_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione tipo de documento</option>
                                        @foreach($tiposDocumento as $tipo)
                                            <option value="{{ $tipo->id_tipo_documento }}" {{ old('tipo_documento_id') == $tipo->id_tipo_documento ? 'selected' : '' }}>
                                                {{ $tipo->nombre_tipo_documento }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="numero_documento" class="block text-sm font-medium text-gray-700">
                                        Número de Documento <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="sexo" class="block text-sm font-medium text-gray-700">
                                        Genero <span class="text-red-500">*</span>
                                    </label>
                                    <select name="sexo" id="sexo"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione Genero</option>
                                        <option value="MASCULINO" {{ old('sexo') == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                                        <option value="FEMENINO" {{ old('sexo') == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                                        <option value="OTRO" {{ old('sexo') == 'OTRO' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="estado_civil" class="block text-sm font-medium text-gray-700">
                                        Estado Civil <span class="text-red-500">*</span>
                                    </label>
                                    <select name="estado_civil" id="estado_civil"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione estado civil</option>
                                        <option value="Soltero(a)" {{ old('estado_civil') == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                        <option value="Casado(a)" {{ old('estado_civil') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                        <option value="Union Libre" {{ old('estado_civil') == 'Union Libre' ? 'selected' : '' }}>Union Libre</option>
                                        <option value="Viudo(a)" {{ old('estado_civil') == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                                        <option value="Divorciado(a)" {{ old('estado_civil') == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="nivel_educativo" class="block text-sm font-medium text-gray-700">
                                        Nivel Educativo <span class="text-red-500">*</span>
                                    </label>
                                    <select name="nivel_educativo" id="nivel_educativo"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione nivel educativo</option>
                                        <option value="Primaria" {{ old('nivel_educativo') == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                                        <option value="Secundaria" {{ old('nivel_educativo') == 'Secundaria' ? 'selected' : '' }}>Bachillerato Incompleto</option>
					 <option value="Bachillerato" {{ old('nivel_educativo') == 'Bachillerato Completo' ? 'selected' : '' }}>Bachillerato Completo</option>	
                                        <option value="Técnico" {{ old('nivel_educativo') == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                                        <option value="Tecnólogo" {{ old('nivel_educativo') == 'Tecnólogo' ? 'selected' : '' }}>Tecnólogo</option>
                                        <option value="Profesional" {{ old('nivel_educativo') == 'Profesional' ? 'selected' : '' }}>Profesional</option>
                                        <option value="Especialización" {{ old('nivel_educativo') == 'Especialización' ? 'selected' : '' }}>Especialización</option>
                                        <option value="Maestría" {{ old('nivel_educativo') == 'Maestría' ? 'selected' : '' }}>Maestría</option>
                                        <option value="Doctorado" {{ old('nivel_educativo') == 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="rango_edad_id" class="block text-sm font-medium text-gray-700">
                                        Rango de Edad <span class="text-red-500">*</span>
                                    </label>
                                    <select name="rango_edad_id" id="rango_edad_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                        <option value="">Seleccione rango de edad</option>
                                        @foreach($rangosEdad as $rango)
                                            <option value="{{ $rango->id_rango }}" {{ old('rango_edad_id') == $rango->id_rango ? 'selected' : '' }}>
                                                ({{ $rango->edad_minima }} - {{ $rango->edad_maxima }} años)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="etnia_id" class="block font-medium text-sm text-gray-700">Etnia</label>
                                    <select name="etnia_id" id="etnia_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Selecciona una etnia</option>
                                        @foreach ($etnias as $etnia)
                                            <option value="{{ $etnia->id }}" {{ old('etnia_id') == $etnia->id ? 'selected' : '' }}>
                                                {{ $etnia->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="grupo_sanguineo_id" class="block font-medium text-sm text-gray-700">Grupo sanguineo</label>
                                    <select name="grupo_sanguineo_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-nonet" required>
                                        <option value="">Seleccione grupo sanguíneo</option>
                                        @foreach($gruposSanguineos as $grupo)
                                            <option value="{{ $grupo->id }}" {{ old('grupo_sanguineo_id') == $grupo->id ? 'selected' : '' }}>
                                                {{ $grupo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Padre o Madre -->
                                <div>
                                    <label for="padre_o_madre" class="block text-sm font-medium text-gray-700">¿Es padre o madre?</label>
                                    <select name="padre_o_madre" id="padre_o_madre" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione</option>
                                        <option value="1" {{ old('padre_o_madre') === '1' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ old('padre_o_madre') === '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div> 
                            <!-- Tipo de vivienda -->
                                <div class="mb-4">
                                    <label for="tipo_vivienda" class="block text-sm font-medium text-gray-700">Tipo de Vivienda</label>
                                    <input type="text" name="tipo_vivienda" id="tipo_vivienda" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Ej. Propia, Arrendada" value="{{ old('tipo_vivienda') }}">
                                </div>
                                <!-- Estrato -->
                                <div class="mb-4">
                                    <label for="estrato" class="block text-sm font-medium text-gray-700">Estrato</label>
                                    <input type="number" name="estrato" id="estrato" min="1" max="6" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" value="{{ old('estrato') }}" required>
                                </div>
                                <!-- Vehículo propio -->
                                 <div>
                                    <label for="vehiculo_propio" class="block text-sm font-medium text-gray-700">¿Posee vehículo propio?</label>
                                    <select name="vehiculo_propio" id="vehiculo_propio" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"required>
                                        <option value="">Seleccione</option>
                                        <option value="1" {{ old('vehiculo_propio') === '1' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ old('vehiculo_propio') === '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <!-- Tipo de vehículo -->
                                <div class="mb-4">
                                    <label for="tipo_vehiculo" class="block text-sm font-medium text-gray-700">Tipo de Vehículo</label>
                                    <input type="text" name="tipo_vehiculo" id="tipo_vehiculo" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" value="{{ old('tipo_vehiculo') }}" required>
                                </div>

                                <!-- Movilidad -->
                                <div class="mb-4">
                                    <label for="movilidad" class="block text-sm font-medium text-gray-700">Medio de Movilidad</label>
                                    <input type="text" name="movilidad" id="movilidad" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" value="{{ old('movilidad') }}">
                                </div>

                                <!-- Institución educativa -->
                                <div class="mb-4">
                                    <label for="institucion_educativa" class="block text-sm font-medium text-gray-700">Institución Educativa</label>
                                    <input type="text" name="institucion_educativa" id="institucion_educativa" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" value="{{ old('institucion_educativa') }}" required>
                                </div>

                                <!-- Idiomas -->
                                <div class="mb-4">
                                    <label for="idiomas" class="block text-sm font-medium text-gray-700">Idiomas</label>
                                    <textarea name="idiomas" id="idiomas" rows="2" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Ej. Inglés - Intermedio, Francés - Básico" required>{{ old('idiomas') }}</textarea>
                                </div>

                                <!-- Intereses personales -->
                                <div class="mb-4">
                                    <label for="intereses_personales" class="block text-sm font-medium text-gray-700">Intereses personales</label>
                                    <textarea name="intereses_personales" id="intereses_personales" rows="2" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">{{ old('intereses_personales') }}</textarea>
                                </div>

                            </div>
                            <!-- Script JSON oculto para Alpine.js -->

                            <!-- Patologías -->
                            <div 
                                x-data="{ patologias: [] }" 
                                x-init="patologias = {{ json_encode(old('patologias', [])) }};" 
                            >
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Patologías</h3>
                                    <button type="button" @click="patologias.push({ nombre_patologia: '', fecha_diagnostico: '', gravedad_patologia: '', descripcion_patologia: '', tratamiento_actual_patologia: '' })" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-slate-800 hover:bg-slate-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Agregar
                                </button>
                            </div>

                            <div class="space-y-4">
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
                                                    <input type="text" x-model="item.nombre_patologia" :name="'patologias['+index+'][nombre_patologia]'" :id="'patologias['+index+'][nombre_patologia]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Nombre de la patología">
                                                </div>
                                                <div>
                                                    <label :for="'patologias['+index+'][fecha_diagnostico]'" class="block text-sm font-medium text-gray-700">Fecha de Diagnóstico</label>
                                                    <input type="date" x-model="item.fecha_diagnostico" :name="'patologias['+index+'][fecha_diagnostico]'" :id="'patologias['+index+'][fecha_diagnostico]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                                </div>
                                                <div>
                                                    <label :for="'patologias['+index+'][gravedad_patologia]'" class="block text-sm font-medium text-gray-700">Gravedad</label>
                                                    <select x-model="item.gravedad_patologia" :name="'patologias['+index+'][gravedad_patologia]'" :id="'patologias['+index+'][gravedad_patologia]'" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                                        <option value="">Seleccione gravedad</option>
                                                        <option value="Leve">Leve</option>
                                                        <option value="Moderada">Moderada</option>
                                                        <option value="Grave">Grave</option>
                                                        <option value="Muy Grave">Muy Grave</option>
                                                    </select>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label :for="'patologias['+index+'][descripcion_patologia]'" class="block text-sm font-medium text-gray-700">Descripción</label>
                                                    <textarea x-model="item.descripcion_patologia" :name="'patologias['+index+'][descripcion_patologia]'" :id="'patologias['+index+'][descripcion_patologia]'" rows="3" class="mt-1 focus:ring-slate-800 focus:border-slate-800 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Descripción de la patología"></textarea>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label :for="'patologias['+index+'][tratamiento_actual_patologia]'" class="block text-sm font-medium text-gray-700">Tratamiento Actual</label>
                                                    <textarea x-model="item.tratamiento_actual_patologia" :name="'patologias['+index+'][tratamiento_actual_patologia]'" :id="'patologias['+index+'][tratamiento_actual_patologia]'" rows="3" class="mt-1 focus:ring-slate-800 focus:border-slate-800 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Tratamiento actual"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="patologias.length === 0" class="text-center py-4 text-sm text-gray-500">
                                        No se han agregado patologías
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div x-show="activeTab === 'ubicacion'" class="space-y-6">
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Lugar de Nacimiento</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- País de Nacimiento -->
                                    <div>
                                        <label for="pais_id_nacimiento" class="block text-sm font-medium text-gray-700">
                                            País de Nacimiento <span class="text-red-500">*</span>
                                        </label>
                                        <select name="pais_id_nacimiento" id="pais_id_nacimiento" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                            <option value="">Seleccione país</option>
                                            @foreach($paises as $pais)
                                                <option value="{{ $pais->id_pais }}" {{ old('pais_id_nacimiento') == $pais->id_pais ? 'selected' : '' }}>
                                                    {{ $pais->nombre_pais }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Departamento de Nacimiento -->
                                    <div>
                                        <label for="departamento_id_nacimiento" class="block text-sm font-medium text-gray-700">
                                            Departamento <span class="text-red-500">*</span>
                                        </label>
                                        <select name="departamento_id_nacimiento" id="departamento_id_nacimiento" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                            <option value="">Seleccione departamento</option>
                                        </select>
                                    </div>
                                    <!-- Municipio de Nacimiento -->
                                    <div>
                                        <label for="municipio_id_nacimiento" class="block text-sm font-medium text-gray-700">
                                            Municipio <span class="text-red-500">*</span>
                                        </label>
                                        <select name="municipio_id_nacimiento" id="municipio_id_nacimiento" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                            <option value="">Seleccione municipio</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-6 border-gray-200">
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Lugar de Residencia</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- País de Residencia -->
                                    <div>
                                        <label for="pais_id_residencia" class="block text-sm font-medium text-gray-700">
                                            País de Residencia <span class="text-red-500">*</span>
                                        </label>
                                        <select name="pais_id_residencia" id="pais_id_residencia" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                            <option value="">Seleccione país</option>
                                            @foreach($paises as $pais)
                                                <option value="{{ $pais->id_pais }}" {{ old('pais_id_residencia') == $pais->id_pais ? 'selected' : '' }}>
                                                    {{ $pais->nombre_pais }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Departamento de Residencia -->
                                    <div>
                                        <label for="departamento_id_residencia" class="block text-sm font-medium text-gray-700">
                                            Departamento <span class="text-red-500">*</span>
                                        </label>
                                        <select name="departamento_id_residencia" id="departamento_id_residencia" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                            <option value="">Seleccione departamento</option>
                                        </select>
                                    </div>
                                    <!-- Municipio de Residencia -->
                                    <div>
                                        <label for="municipio_id_residencia" class="block text-sm font-medium text-gray-700">
                                            Municipio <span class="text-red-500">*</span>
                                        </label>
                                        <select name="municipio_id_residencia" id="municipio_id_residencia" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                            <option value="">Seleccione municipio</option>
                                        </select>
                                    </div>
                                    <!-- Barrio de Residencia -->
                                    <div>
                                        <label for="barrio_id_residencia" class="block text-sm font-medium text-gray-700">
                                            Barrio <span class="text-red-500">*</span>
                                        </label>
                                        <select name="barrio_id_residencia" id="barrio_id_residencia" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" required>
                                            <option value="">Seleccione barrio</option>
                                            @foreach($barrios as $barrio)
                                                <option value="{{ $barrio->id_barrio }}" {{ old('barrio_id_residencia') == $barrio->id_barrio ? 'selected' : '' }}>
                                                    {{ $barrio->nombre_barrio }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Dirección -->
                                    <div>
                                        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                                        <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                            placeholder="Dirección de residencia">
                                    </div>
                                    <!-- Teléfono -->
                                    <div>
                                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                            placeholder="Número de teléfono">
                                    </div>
                                    <!-- Teléfono fijo -->
                                    <div>
                                        <label for="telefono_fijo" class="block text-sm font-medium text-gray-700">Teléfono Fijo</label>
                                        <input type="text" name="telefono_fijo" id="telefono_fijo" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"value="{{ old('telefono_fijo', $informacionLaboral->telefono_fijo ?? '') }}">
                                    </div>
                                    <!-- Correo Electrónico -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                            placeholder="correo@ejemplo.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Información Laboral -->
                        <div x-show="activeTab === 'laboral'" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <label for="empresa_id" class="block text-sm font-medium text-gray-700">Empresa</label>
                                    <select id="empresa_id" name="empresa_id"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Selecciona Empresa</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id_empresa }}" {{ old('empresa_id') == $empresa->id_empresa ? 'selected' : '' }}>
                                                {{ $empresa->nombre_empresa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="cargo_id" class="block text-sm font-medium text-gray-700">Cargo</label>
                                    <select id="cargo_id" name="cargo_id"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Selecciona Cargo</option>
                                    </select>
                                    <p id="cargo_error" class="mt-1 text-sm text-red-600" style="display:none;">Error al cargar cargos. Intenta nuevamente.</p>
                                </div>
                                
                                <div>
                                    <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">
                                        Fecha de Ingreso <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso') }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none"
                                        required>
                                </div>
                                <div>
                                    <label for="fecha_salida" class="block text-sm font-medium text-gray-700">
                                        Fecha de Salida <span class="text-red-500"></span>
                                    </label>
                                    <input type="date" name="fecha_salida" id="fecha_salida" value=""
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                </div>
                                <div>
                                    <label for="tipo_contrato" class="block text-sm font-medium text-gray-700">Tipo de Contrato</label>
                                    <select name="tipo_contrato" id="tipo_contrato"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione tipo de contrato</option>
                                        <option value="Indefinido" {{ old('tipo_contrato') == 'Indefinido' ? 'selected' : '' }}>Indefinido</option>
                                        <option value="Fijo" {{ old('tipo_contrato') == 'Fijo' ? 'selected' : '' }}>Término Fijo</option>
                                        <option value="Obra Labor" {{ old('tipo_contrato') == 'Obra Labor' ? 'selected' : '' }}>Obra o Labor</option>
                                        <option value="Prestación de Servicios" {{ old('tipo_contrato') == 'Prestación de Servicios' ? 'selected' : '' }}>Prestación de Servicios</option>
                                        <option value="Aprendizaje" {{ old('tipo_contrato') == 'Aprendizaje' ? 'selected' : '' }}>Aprendizaje</option>
                                    </select>
                                </div>
                                <!-- EPS -->
                                <div >
                                    <label for="eps_id">EPS</label>
                                    <select name="eps_id" id="eps_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione EPS</option>
                                        @foreach($eps as $e)
                                            <option value="{{ $e->id }}" {{ old('eps_id', $empleado->eps_id ?? '') == $e->id ? 'selected' : '' }}>
                                                {{ $e->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- AFP -->
                                <div >
                                    <label for="afp_id">AFP</label>
                                    <select name="afp_id" id="afp_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione AFP</option>
                                        @foreach($afp as $a)
                                            <option value="{{ $a->id }}" {{ old('afp_id', $empleado->afp_id ?? '') == $a->id ? 'selected' : '' }}>
                                                {{ $a->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- ARL -->
                                <div >
                                    <label for="arl_id" class="block text-sm font-medium text-gray-700">ARL</label>
                                    <select name="arl_id" id="arl_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione ARL</option>
                                        @foreach($arl as $a)
                                            <option value="{{ $a->id }}" {{ old('arl_id', $empleado->arl_id ?? '') == $a->id ? 'selected' : '' }}>
                                                {{ $a->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- AFC -->
                                <div class="mb-4">
                                    <label for="afc_id" class="block text-sm font-medium text-gray-700">AFC</label>
                                    <select name="afc_id" id="afc_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione una opción</option>
                                        @foreach($afcs as $afc)
                                            <option value="{{ $afc->id }}" {{ old('afc_id', $empleado->afc_id ?? '') == $afc->id ? 'selected' : '' }}>
                                                {{ $afc->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Caja de Compensación -->
                                <div>
                                    <label for="ccf_id">Caja de Compensación</label>
                                    <select name="ccf_id" id="ccf_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                           <option value="">Seleccione Caja de Compensación</option>
                                        @foreach($ccf as $c)
                                            <option value="{{ $c->id }}" {{ old('ccf_id', $empleado->ccf_id ?? '') == $c->id ? 'selected' : '' }}>
                                                {{ $c->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Ciudad laboral -->
                                <div>
                                    <label for="ciudad_laboral_id" class="block text-sm font-medium text-gray-700">Ciudad Laboral</label>
                                    <select name="ciudad_laboral_id" id="ciudad_laboral_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione ciudad laboral</option>
                                        @foreach($ciudades as $ciudad)
                                            <option value="{{ $ciudad->id }}" {{ old('ciudad_laboral_id') == $ciudad->id ? 'selected' : '' }}>
                                                {{ $ciudad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                               <div>
                                    <label for="ubicacion_fisica" class="block text-sm font-medium text-gray-700">Ubicación Física <span class="text-red-600">*</span></label>
                                    <select name="ubicacion_fisica" id="ubicacion_fisica" required class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione una opción</option>
                                        <option value="Planta" {{ old('ubicacion_fisica', $informacionLaboral->ubicacion_fisica ?? '') == 'Planta' ? 'selected' : '' }}>Planta</option>
                                        <option value="Oficina" {{ old('ubicacion_fisica', $informacionLaboral->ubicacion_fisica ?? '') == 'Oficina' ? 'selected' : '' }}>Oficina</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="arl_id" class="block text-sm font-medium text-gray-700">¿Necesita Dotacion?</label>
                                    <select name="aplica_dotacion" id="aplica_dotacion" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none appearance-none">
                                        <option value="">Seleccione</option>
                                        <option value="1" {{ old('aplica_dotacion', $informacionLaboral->aplica_dotacion ?? '') == '1' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ old('aplica_dotacion', $informacionLaboral->aplica_dotacion ?? '') == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="talla_camisa" class="block text-sm font-medium text-gray-700">Talla de camisa</label>
                                    <input type="text" name="talla_camisa" id="talla_camisa" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Ej. M, L, XL" value="{{ old('talla_camisa', $informacionLaboral->talla_camisa ?? '') }}">
                                </div>

                                <!-- Talla pantalón -->
                                <div>
                                    <label for="talla_pantalon" class="block text-sm font-medium text-gray-700">Talla de pantalón</label>
                                    <input type="text" name="talla_pantalon" id="talla_pantalon" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Ej. 32, 34" value="{{ old('talla_pantalon', $informacionLaboral->talla_pantalon ?? '') }}">
                                </div>

                                <!-- Talla zapatos -->
                                <div>
                                    <label for="talla_zapatos" class="block text-sm font-medium text-gray-700">Talla de zapatos</label>
                                    <input type="text" name="talla_zapatos" id="talla_zapatos" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none" placeholder="Ej. 38, 40" value="{{ old('talla_zapatos', $informacionLaboral->talla_zapatos ?? '') }}">
                                </div>
                                <!-- Tipo de vinculacion -->
                                <div>
                                    <label for="tipo_vinculacion" class="block text-sm font-medium text-gray-700">Tipo de vinculacion</label> 
                                    <select name="tipo_vinculacion" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-out focus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Tipo de vinculacion</option>
                                        <option value="Directo" {{ old('tipo_vinculacion', $informacionLaboral->tipo_vinculacion ?? '') == 'Directo' ? 'selected' : '' }}>Directo</option>
                                        <option value="Indirecto" {{ old('tipo_vinculacion', $informacionLaboral->tipo_vinculacion ?? '') == 'Indirecto' ? 'selected' : '' }}>Indirecto</option>
                                    </select>
                                </div>
                                <!-- Tiene relacion sindical -->
                                <div>
                                    <label for="relacion_sindical" class="block text-sm font-medium text-gray-700">¿Tiene relación sindical?</label>
                                    <select name="relacion_sindical" id="relacion_sindical" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm shadow-md transition-all duration-200 ease-in-outfocus:border-sky-500 focus:ring-2 focus:ring-sky-400 focus:bg-white focus:outline-none">
                                        <option value="">Seleccione</option>
                                        <option value="SI" {{ old('relacion_sindical', $empleado->informacionLaboral->relacion_sindical ?? '') == 'SI' ? 'selected' : '' }}>Sí</option>
                                        <option value="NO" {{ old('relacion_sindical', $empleado->informacionLaboral->relacion_sindical ?? '') == 'NO' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <!-- Relación Laboral -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Relación laboral</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @php
                                                $opciones = ['Ley 50', 'Salario Integral', 'Sin ninguna prestación'];
                                                $seleccionadas = old('informacion_laboral.relacion_laboral', explode(',', $informacionLaboral->relacion_laboral ?? ''));
                                            @endphp

                                            @foreach ($opciones as $opcion)
                                                <label class="flex items-center space-x-2 text-sm text-gray-700 bg-gray-100 px-4 py-2 rounded-md shadow-sm">
                                                    <input type="checkbox"
                                                        name="informacion_laboral[relacion_laboral][]"
                                                        value="{{ $opcion }}"
                                                        @checked(in_array($opcion, $seleccionadas))
                                                        class="text-pink-600 focus:ring-pink-500 border-gray-300 rounded" />
                                                    <span>{{ $opcion }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                               <hr class="my-6 border-gray-200">
                                <div>
                                    <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" rows="4" class="mt-1 focus:ring-slate-800 focus:border-slate-800 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Observaciones adicionales sobre el empleado">{{ old('observaciones') }}</textarea>
                                </div>
                            </div>
                        </div>
                         <!-- Beneficiarios -->
                        <div x-show="activeTab === 'adicional'" >
                            <div x-data="{ beneficiarios: [] }" x-init="beneficiarios = {{ json_encode(old('beneficiarios', [])) }}; " class="p-6 border-t border-gray-200">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Beneficiarios</h3>
                                    <button type="button" @click="beneficiarios.push({ 
                                        nombre_beneficiario: '', 
                                        parentesco: '', 
                                        fecha_nacimiento: '', 
                                        tipo_documento_id: '', 
                                        numero_documento: '', 
                                        nivel_educativo: '',
                                        reside_con_empleado: '0',
                                        depende_economicamente: '0',
                                        contacto_emergencia: ''
                                         })" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-slate-800 hover:bg-slate-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Agregar
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <template x-for="(item, index) in beneficiarios" :key="index">
                                        <div class="bg-gray-50 rounded-lg p-4 relative" x-data="{ tipoUnion: '' }">
                                            <button type="button" @click="beneficiarios.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <!-- Campos comunes -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label :for="'beneficiarios['+index+'][nombre_beneficiario]'" class="block text-sm font-medium text-gray-700">Nombre Completo <span class="text-red-500">*</span></label>
                                                    <input type="text" :name="'beneficiarios['+index+'][nombre_beneficiario]'" x-model="item.nombre_beneficiario" class="mt-2 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm">
                                                </div>
                                                <div>
                                                    <label :for="'beneficiarios['+index+'][parentesco]'" class="block text-sm font-medium text-gray-700">Parentesco <span class="text-red-500">*</span></label>
                                                    <select :name="'beneficiarios['+index+'][parentesco]'" x-model="item.parentesco" class="mt-2 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm">
                                                        <option value="">Seleccione parentesco</option>
                                                        <option value="Cónyuge">Cónyuge</option>
                                                        <option value="Hijo/a">Hijo/a</option>
                                                        <option value="Padre">Padre</option>
                                                        <option value="Madre">Madre</option>
                                                        <option value="Hermano/a">Hermano/a</option>
                                                        <option value="Otro">Otro</option>
                                                    </select>
                                                </div>
                                                </div> 
                                                <!-- Agregar esta sección -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                    <!-- Fecha de Nacimiento -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                                                        <input type="date" :name="'beneficiarios['+index+'][fecha_nacimiento]'" x-model="item.fecha_nacimiento" 
                                                            class="w-full rounded border border-gray-300 px-3 py-2">
                                                    </div>
                                                    
                                                    <!-- Tipo de Documento -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                                                        <select :name="'beneficiarios['+index+'][tipo_documento_id]'" x-model="item.tipo_documento_id" 
                                                                class="w-full rounded border border-gray-300 px-3 py-2">
                                                            <option value="">Seleccione tipo de documento</option>
                                                            @foreach($tiposDocumento as $tipo)
                                                                <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->nombre_tipo_documento }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Número de Documento -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Número de Documento</label>
                                                        <input type="text" :name="'beneficiarios['+index+'][numero_documento]'" x-model="item.numero_documento" 
                                                            class="w-full rounded border border-gray-300 px-3 py-2" placeholder="Número de documento">
                                                    </div>
                                                    
                                                    <!-- Nivel Educativo -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Nivel Educativo</label>
                                                        <select :name="'beneficiarios['+index+'][nivel_educativo]'" x-model="item.nivel_educativo" 
                                                                class="w-full rounded border border-gray-300 px-3 py-2">
                                                            <option value="">Seleccione nivel</option>
                                                            <option value="Primaria">Primaria</option>
                                                            <option value="Bachillerato Incompleto">Bachillerato Incompleto</option>
                                                            <option value="Bachillerato Completo">Bachillerato Completo</option>
                                                            <option value="Técnico">Técnico</option>
                                                            <option value="Tecnológico">Tecnológico</option>
                                                            <option value="Universitario">Universitario</option>
                                                            <option value="Posgrado">Posgrado</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Reside con empleado -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">¿Reside con el empleado?</label>
                                                        <select :name="'beneficiarios['+index+'][reside_con_empleado]'" x-model="item.reside_con_empleado" 
                                                                class="w-full rounded border border-gray-300 px-3 py-2">
                                                            <option value="1">Sí</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Depende económicamente -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">¿Depende económicamente?</label>
                                                        <select :name="'beneficiarios['+index+'][depende_economicamente]'" x-model="item.depende_economicamente" 
                                                                class="w-full rounded border border-gray-300 px-3 py-2">
                                                            <option value="1">Sí</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Contacto de emergencia -->
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-medium text-gray-700">Contacto de emergencia</label>
                                                        <input type="text" :name="'beneficiarios['+index+'][contacto_emergencia]'" x-model="item.contacto_emergencia" 
                                                            class="w-full rounded border border-gray-300 px-3 py-2" placeholder="Número de contacto">
                                                    </div>
                                                </div>
                                           
                                            </div>
                                            <!-- Hijo/a -->
                                            <div x-show="item.parentesco === 'Hijo/a'" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Registro civil del hijo *</label>
                                                    <input type="file" :name="'beneficiarios['+index+'][registro_hijo]'" class="w-full rounded border border-gray-300">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Tarjeta de identidad / Cédula</label>
                                                    <input type="file" :name="'beneficiarios['+index+'][cedula_hijo]'" class="w-full rounded border border-gray-300">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Certificado de estudio</label>
                                                    <input type="file" :name="'beneficiarios['+index+'][certificado_estudio_hijo]'" class="w-full rounded border border-gray-300">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Certificado EPS</label>
                                                    <input type="file" :name="'beneficiarios['+index+'][eps_hijo]'" class="w-full rounded border border-gray-300">
                                                </div>
                                            </div>

                                            <!-- Padre / Madre -->
                                            <div x-show="item.parentesco === 'Padre' || item.parentesco === 'Madre'" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Registro civil del empleado</label>
                                                    <input type="file" :name="'beneficiarios['+index+'][registro_empleado]'" class="w-full rounded border border-gray-300">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Cédula del padre/madre</label>
                                                    <input type="file" :name="'beneficiarios['+index+'][cedula_padre_madre]'" class="w-full rounded border border-gray-300">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Certificado EPS</label>
                                                    <input type="file" :name="'beneficiarios['+index+'][eps_padre_madre]'" class="w-full rounded border border-gray-300">
                                                </div>
                                            </div>

                                            <!-- Cónyuge -->
                                            <div x-show="item.parentesco === 'Cónyuge'" class="space-y-4 mt-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Tipo de unión</label>
                                                    <select x-model="tipoUnion" class="w-full rounded border border-gray-300">
                                                        <option value="">Seleccione</option>
                                                        <option value="casado">Casados</option>
                                                        <option value="union">Unión libre</option>
                                                    </select>
                                                </div>
                                                <div x-show="tipoUnion === 'casado'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Registro civil de matrimonio *</label>
                                                        <input type="file" :name="'beneficiarios['+index+'][registro_matrimonio]'" class="w-full rounded border border-gray-300">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Cédula del cónyuge *</label>
                                                        <input type="file" :name="'beneficiarios['+index+'][cedula_conyuge]'" class="w-full rounded border border-gray-300">
                                                    </div>
                                                </div>
                                                <div x-show="tipoUnion === 'union'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Declaración extra-juicio *</label>
                                                        <input type="file" :name="'beneficiarios['+index+'][declaracion_union]'" class="w-full rounded border border-gray-300">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Cédula del compañero *</label>
                                                        <input type="file" :name="'beneficiarios['+index+'][cedula_companero]'" class="w-full rounded border border-gray-300">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="beneficiarios.length === 0" class="text-center py-4 text-sm text-gray-500">
                                        No se han agregado beneficiarios
                                    </div>
                                </div>
                                <!-- DOCUMENTACIÓN GENERAL -->
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch("{{ url('/api/barrios') }}")
                .then(response => response.json())
                .then(barrios => {
                    const select = document.getElementById("barrio_id_residencia");

                    // Si estás usando old('barrio_id_residencia'), lo puedes leer aquí
                    const oldValue = "{{ old('barrio_id_residencia') }}";

                    barrios.forEach((barrio, index) => {
                        const option = document.createElement("option");
                        option.value = index + 1; // O simplemente barrio si no tienes ID
                        option.textContent = barrio;

                        if (option.value == oldValue) {
                            option.selected = true;
                        }

                        select.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("❌ Error al cargar los barrios:", error);
                });
        });
    </script>
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