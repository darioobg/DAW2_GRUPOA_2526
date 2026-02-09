<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProyectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Solo validación para creación/actualización de proyecto.
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_creacion' => 'required|date',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin_prevista' => 'nullable|date|after_or_equal:fecha_inicio',
            'id_estado_proyecto' => 'required|integer',
            'id_equipo' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder 255 caracteres.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'fecha_creacion.required' => 'La fecha de creación es obligatoria.',
            'fecha_creacion.date' => 'La fecha de creación debe ser una fecha válida.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin_prevista.date' => 'La fecha fin prevista debe ser una fecha válida.',
            'fecha_fin_prevista.after_or_equal' => 'La fecha fin prevista debe ser igual o posterior a la fecha de inicio.',
            'id_estado_proyecto.required' => 'El estado del proyecto es obligatorio.',
            'id_estado_proyecto.integer' => 'El estado del proyecto debe ser un número entero.',
            'id_equipo.integer' => 'El equipo debe ser un número entero.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'ok' => false,
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
