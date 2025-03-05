<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorrectPostRequest extends FormRequest
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
            'date' => 'required',
            'begin_at' => 'required|before:finish_at',
            'finish_at' => 'required',
            'type' => 'required',
            'note' => 'required|max:255',
            'rest' => 'required',
            'rest.*.begin_at' => 'required|before:rest.*.finish_at|after:begin_at',
            'rest.*.finish_at' => 'required|before:finish_at',
        ];
    }
}
