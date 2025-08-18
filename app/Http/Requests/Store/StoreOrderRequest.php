<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreOrderRequest extends FormRequest
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
            'destination_id' => 'required|exists:destinations,id',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:departure_date',
            
        ];
    }

    /**
     * Get custom error messages for the validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'destination_id.required' => 'O destino é obrigatório.',
            'destination_id.exists' => 'O destino selecionado não existe.',
            'departure_date.required' => 'A data de ida é obrigatória.',
            'departure_date.date' => 'A data de ida deve ser uma data válida.',
            'departure_date.after_or_equal' => 'A data de ida deve ser hoje ou uma data futura.',
            'return_date.required' => 'A data de volta é obrigatória.',
            'return_date.date' => 'A data de volta deve ser uma data válida.',
            'return_date.after' => 'A data de volta deve ser posterior à data de ida.',
        ];
    }
}
