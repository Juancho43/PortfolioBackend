<?php

namespace App\Http\Requests\V1;

use App\Http\Exceptions\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'rol' => 'required|string|max:100',
            'description' => 'nullable|string|max:65535',
            'education' => 'nullable|array',
            'education.*' => 'integer|exists:education,id',
            'works' => 'nullable|array',
            'works.*' => 'integer|exists:works,id',
            'links' => 'nullable|array',
            'links.*' => 'integer|exists:links,id'
        ];
    }
}
