<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',

            'items' => 'required|array|min:1',

            'items.*.burger_id' => 'required|exists:burgers,id',

            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Le client est obligatoire.',
            'user_id.exists' => 'Client invalide.',

            'items.required' => 'La commande doit contenir au moins un burger.',
            'items.array' => 'Format de commande invalide.',

            'items.*.burger_id.required' => 'Burger obligatoire.',
            'items.*.burger_id.exists' => 'Burger inexistant.',

            'items.*.quantity.required' => 'La quantité est obligatoire.',
            'items.*.quantity.integer' => 'La quantité doit être un entier.',
            'items.*.quantity.min' => 'La quantité doit être supérieure à zéro.',
        ];
    }
}