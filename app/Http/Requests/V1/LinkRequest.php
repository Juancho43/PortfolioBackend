<?php

namespace App\Http\Requests\V1;

use App\Http\Exceptions\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
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
            'name' => 'required|string|max:45',
            'link' => 'required|string|max:255',
            'delete_at' => 'nullable|date',
        ];
    }
}
