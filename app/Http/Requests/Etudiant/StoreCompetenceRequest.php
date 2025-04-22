<?php

namespace App\Http\Requests\Etudiant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCompetenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'categorie' => 'required|string|max:100',
            'nom'       => 'required|string|max:100',
            'niveau'    => 'required|integer|min:0|max:100', // Pourcentage de 0 à 100
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
         return [
             'required' => 'Le champ :attribute est obligatoire.',
             'string'   => 'Le champ :attribute doit être du texte.',
             'integer'  => 'Le niveau doit être un nombre entier.',
             'min'      => 'Le niveau doit être au moins :min.',
             'max'      => 'Le niveau ne peut pas dépasser :max.',
             '*.max'    => 'Le champ :attribute ne doit pas dépasser :max caractères.',
         ];
    }
}