<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'company' => 'required|string|max:45',
            'position' => 'required|string|max:45',
            'responsabilities' => 'nullable|string|max:65535',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'delete_at' => 'nullable|date'

        ];
    }
}
