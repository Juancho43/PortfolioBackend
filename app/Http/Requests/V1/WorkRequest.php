<?php

namespace App\Http\Requests\V1;

use App\Http\Exceptions\AuthenticationException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @throws AuthenticationException
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'company' => 'required|string|max:45',
            'position' => 'required|string|max:45',
            'responsibilities' => 'nullable|string|max:65535',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'delete_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',  // Si es un array de IDs de tags
            'links' => 'nullable|array',
            'links.*' => 'integer|exists:links,id'

        ];
    }
}
