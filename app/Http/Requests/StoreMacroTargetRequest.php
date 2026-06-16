<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMacroTargetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weight_kg'      => ['required', 'numeric', 'min:20', 'max:300'],
            'height_cm'      => ['required', 'numeric', 'min:100', 'max:250'],
            'age'            => ['required', 'integer', 'min:16', 'max:100'],
            'sex'            => ['required', 'in:male,female'],
            'activity_level' => ['required', 'in:sedentary,light,moderate,active,very_active'],
            'goal'           => ['required', 'in:lose,maintain,gain'],
            'preset'         => ['nullable', 'in:balanced,high_protein,keto,low_carb'],
        ];
    }
}
