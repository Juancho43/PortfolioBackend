<?php

namespace App\Http\Requests\V1;

use App\Http\Exceptions\AuthenticationException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|integer',
            'name'=>'required|max:50',
        ];
    }
}
