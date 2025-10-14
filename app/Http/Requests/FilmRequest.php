<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
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
            'title' => 'required|string|min:2',
            'directorId' => 'required|numeric',
            'description' => 'required|string|min:10',
            'picture' => 'required|string|min:20',
            'typeId' => 'numeric',
            'lenght' => 'nullable|numeric',
        ];
    }
}
