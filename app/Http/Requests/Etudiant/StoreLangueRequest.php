<?php

namespace App\Http\Requests\Etudiant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Important pour Rule::in

class StoreLangueRequest extends FormRequest
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
        // Liste des niveaux valides attendus par le <select> du formulaire
        $validLevels = ['Natif', 'Courant', 'Intermédiaire', 'Débutant', 'Notions'];

        return [
            'langue' => 'required|string|max:50',
            'niveau' => ['required', 'string', Rule::in($validLevels)], // Assure que la valeur est dans la liste
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
             'langue.max' => 'La langue ne doit pas dépasser 50 caractères.',
             'niveau.in' => 'Le niveau sélectionné n\'est pas valide.',
         ];
     }
}