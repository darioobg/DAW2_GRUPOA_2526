<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoFiltroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'nullable|string',
            'id_estado_proyecto' => 'nullable|integer',
            'fecha_inicio_desde' => 'nullable|date',
            'fecha_inicio_hasta' => 'nullable|date|after_or_equal:fecha_inicio_desde',
        ];
    }
}
