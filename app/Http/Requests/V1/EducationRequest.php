<?php

namespace App\Http\Requests\V1;

use App\Http\Exceptions\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->check()) {
            throw new AuthenticationException();
        }
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
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
            'links' => 'nullable|array',
            'links.*' => 'exists:links,id',
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
        ];
    }
}
