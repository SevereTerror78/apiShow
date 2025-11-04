<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DirectorsRequest extends FormRequest
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
        if($this->method() == 'PATCH'){
            return [
                'name'=>'string|required|min:3',
                'created_at' => 'nullable|string',
                'updated_at'=> 'nullable|string',
            ];          
        }

        return [
            'name'=>'string|required|min:3',
            'created_at' => 'nullable|string',
            'updated_at'=> 'nullable|string',
        ];
    }
}
