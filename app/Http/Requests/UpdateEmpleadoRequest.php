<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpleadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {


        $empleado = $this->route('empleado');
        $empleadoId = is_object($empleado) ? $empleado->id_empleado : $empleado;


        Log::info('Empleado ID en FormRequest:', ['id' => $this->route('empleado')]);

 

        return [
           'tipo_documento_id' => 'required|exists:tipo_documento,id_tipo_documento',
            'numero_documento' => [
                'required',
                'string',
                'min:5',
                'max:11',
                 'unique:empleados,numero_documento,' . $this->route('empleado') . ',id_empleado',
            ],
            'nombre_completo' => [
                'required',
                'string',
                'max:255',
            ],
            'sexo' => 'required|in:MASCULINO,FEMENINO,OTRO',
            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                'after_or_equal:' . now()->subYears(80)->format('Y-m-d')
            ],
            'estado_civil' => 'required|in:Soltero(a),Casado(a),Union Libre,Divorciado(a),Viudo(a)',
            'nivel_educativo' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'nullable',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'unique:empleados,email,' . $this->route('empleado') . ',id_empleado',
                'max:255',
            ],
            'telefono' => [
                'nullable',
                'string',
                'max:15',
            ],
            'direccion' => [
                'nullable',
                'string',
                'max:255',
            ],
            'pais_id_nacimiento' => 'required|exists:pais,id_pais',
            'departamento_id_nacimiento' => 'required|exists:departamento,id_departamento',
            'municipio_id_nacimiento' => 'required|exists:municipio,id_municipio',
            'empresa_id' => 'required|exists:empresa,id_empresa',
            'cargo_id' => 'required|exists:cargo,id_cargo',
            'fecha_ingreso' => [
                'required',
                'date',
                'before_or_equal:' . now()->format('Y-m-d'),
                'after_or_equal:' . now()->subYears(40)->format('Y-m-d')
            ],
            'fecha_salida' => [
                'nullable',
                'date',
                'after_or_equal:fecha_ingreso',
            ],
            'tipo_contrato' => [
                'nullable',
                'string',
                'max:50',
            ],
            'observaciones' => 'nullable|string|max:1000',
            'patologias' => 'nullable|array',
            'patologias.*.nombre_patologia' => [
                'required_with:patologias',
                'string',
                'max:255',
            ],
            'patologias.*.fecha_diagnostico' => [
                'nullable',
                'date',
                'before_or_equal:' . now()->format('Y-m-d'),
                'after_or_equal:' . now()->subYears(80)->format('Y-m-d')
            ],
            'patologias.*.gravedad_patologia' => [
                'nullable',
                'string',
                'max:255',
                'in:Leve,Moderada,Grave,Muy Grave'
            ],
            'patologias.*.descripcion_patologia' => 'nullable|string|max:255',
            'patologias.*.tratamiento_actual_patologia' => 'nullable|string|max:255',
        ];

        
    }

    public function messages(): array
    {
        return [
             'tipo_documento_id.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.string' => 'El número de documento debe ser una cadena de texto.',
            'numero_documento.min' => 'El número de documento debe tener al menos 5 caracteres.',
            'numero_documento.max' => 'El número de documento no puede tener más de 11 caracteres.',
            'numero_documento.unique' => 'El número de documento ya está registrado.',
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.string' => 'El nombre completo debe ser una cadena de texto.',
            'nombre_completo.max' => 'El nombre completo no puede tener más de 255 caracteres.',
            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo seleccionado no es válido.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before_or_equal' => 'Debes ser mayor de 18 años.',
            'fecha_nacimiento.after_or_equal' => 'La fecha de nacimiento no puede ser mayor a 80 años atrás.',
            'estado_civil.required' => 'El estado civil es obligatorio.',
            'estado_civil.in' => 'El estado civil seleccionado no es válido.',
            'nivel_educativo.required' => 'El nivel educativo es obligatorio.',
            'nivel_educativo.string' => 'El nivel educativo debe ser una cadena de texto.',
            'nivel_educativo.max' => 'El nivel educativo no puede tener más de 100 caracteres.',
            'email.regex' => 'El correo electrónico debe contener un "@" seguido de un ".".',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no puede tener más de 15 caracteres.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
            'pais_id_nacimiento.required' => 'El país de nacimiento es obligatorio.',
            'pais_id_nacimiento.exists' => 'El país de nacimiento seleccionado no es válido.',
            'departamento_id_nacimiento.required' => 'El departamento de nacimiento es obligatorio.',
            'departamento_id_nacimiento.exists' => 'El departamento de nacimiento seleccionado no es válido.',
            'municipio_id_nacimiento.required' => 'El municipio de nacimiento es obligatorio.',
            'municipio_id_nacimiento.exists' => 'El municipio de nacimiento seleccionado no es válido.',
            'empresa_id.required' => 'La empresa es obligatoria.',
            'empresa_id.exists' => 'La empresa seleccionada no es válida.',
            'cargo_id.required' => 'El cargo es obligatorio.',
            'cargo_id.exists' => 'El cargo seleccionado no es válido.',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'fecha_ingreso.before_or_equal' => 'La fecha de ingreso no puede ser futura.',
            'fecha_ingreso.after_or_equal' => 'La fecha de ingreso no puede ser mayor a 40 años atrás.',
            'fecha_salida.date' => 'La fecha de salida debe ser una fecha válida.',
            'fecha_salida.after_or_equal' => 'La fecha de salida debe ser posterior o igual a la fecha de ingreso.',
            'tipo_contrato.string' => 'El tipo de contrato debe ser una cadena de texto.',
            'tipo_contrato.max' => 'El tipo de contrato no puede tener más de 50 caracteres.',
            'observaciones.string' => 'Las observaciones deben ser una cadena de texto.',
            'observaciones.max' => 'Las observaciones no pueden tener más de 1000 caracteres.',
          
            'patologias.array' => 'Las patologías deben ser un array.',
            'patologias.*.nombre_patologia.required_with' => 'El nombre de la patología es obligatorio cuando hay patologías.',
            'patologias.*.nombre_patologia.string' => 'El nombre de la patología debe ser una cadena de texto.',
            'patologias.*.nombre_patologia.max' => 'El nombre de la patología no puede tener más de 255 caracteres.',
            'patologias.*.fecha_diagnostico.date' => 'La fecha de diagnóstico de la patología debe ser una fecha válida.',
            'patologias.*.fecha_diagnostico.before_or_equal' => 'La fecha de diagnóstico de la patología debe ser menor o igual a hoy.',
            'patologias.*.fecha_diagnostico.after_or_equal' => 'La fecha de diagnóstico de la patología debe ser mayor o igual a hoy menos 80 años.',
            'patologias.*.gravedad_patologia.string' => 'La gravedad de la patología debe ser una cadena de texto.',
            'patologias.*.gravedad_patologia.max' => 'La gravedad de la patología no puede tener más de 255 caracteres.',
            'patologias.*.gravedad_patologia.in' => 'La gravedad de la patología debe ser uno de: Leve, Moderada, Grave, Muy Grave.',
            'patologias.*.descripcion_patologia.string' => 'La descripción de la patología debe ser una cadena de texto.',
            'patologias.*.descripcion_patologian.max' => 'La descripción de la patología no puede tener más de 255 caracteres.',
            'patologias.*.tratamiento_actual_patologia.string' => 'El tratamiento actual de la patología debe ser una cadena de texto.',
            'patologias.*.tratamiento_actual_patologia.max' => 'El tratamiento actual de la patología no puede tener más de 255 caracteres.',
            'beneficiarios.*.reside_con_trabajador' => 'required|boolean',
            'beneficiarios.*.depende_economicamente' => 'required|boolean',
            'beneficiarios.*.contacto_emergencia' => 'nullable|string|max:255',

            'tipo_vivienda' => 'nullable|string|max:100',
            'estrato' => 'nullable|integer|min:0|max:6',
            'vehiculo_propio' => 'nullable|boolean',
            'tipo_vehiculo' => 'nullable|string|max:100',
            'movilidad' => 'nullable|string|max:255',
            'institucion_educativa' => 'nullable|string|max:255',
            'intereses_personales' => 'nullable|string|max:255',
            'idiomas' => 'nullable|string|max:255',
            'grupo_sanguineo_id' => 'nullable|exists:grupos_sanguineos,id',
            'etnia_id' => 'nullable|exists:etnias,id',
            'padre_o_madre' => 'nullable|string|max:50',
            'ubicacion_fisica' => 'nullable|string|max:255',
            'ciudad_laboral_id' => 'nullable|exists:ciudad_laborales,id',
            'tipo_vinculacion' => 'nullable|string|max:255',
            'tipo_vinculacion' => 'nullable|string|max:255',
            'proceso_gerencia' => 'nullable|string|max:255',
            'relacion_laboral' => 'nullable|string|max:255',
            'relacion_sindical' => 'nullable|string|max:255',
            'aplica_dotacion' => 'nullable|boolean',
            'talla_camisa' => 'nullable|string|max:10',
            'talla_pantalon' => 'nullable|string|max:10',
            'talla_zapatos' => 'nullable|string|max:10',
        ];
    }
}
