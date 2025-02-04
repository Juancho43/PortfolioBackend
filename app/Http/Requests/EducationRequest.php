<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'startDate' => 'required|date', 
            'endDate' => 'nullable|date|after:startDate', 
            'delete_at' => 'nullable|date', 
            'type' => ['required', Rule::in(['Academico', 'Curso'])], 
            'profile_id' => 'required|exists:users,id', 
            
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
            'startDate.required' => "La fecha de inicio es requerida.",
            'type.required' => "El tipo es requerido.",
            'profile_id.required' => "El usuario es requerido.",
        ];
    }
}
