<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'delete_at' => 'nullable|date',
        ];
    }

    /**
     * Custom error messages (Optional)
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => "El nombre es requerido.",
            'description.required' => "La descripción es requerida.",
            'start_date.required' => "La fecha de inicio es requerida.",
            'type.required' => "El tipo es requerido.",
        ];
    }
}
