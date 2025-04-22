<?php

namespace App\Http\Requests\Etudiant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ajouter vérification de propriété si nécessaire
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
            'poste'              => 'required|string|max:255',
            'entreprise'         => 'required|string|max:255',
            'ville'              => 'nullable|string|max:100',
            'date_debut'         => 'required|date',
            'date_fin'           => 'nullable|date|after_or_equal:date_debut',
            'description'        => 'nullable|string|max:3000',
            'taches_realisations'=> 'nullable|string|max:3000',
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
             'required'               => 'Le champ :attribute est obligatoire.',
             'string'                 => 'Le champ :attribute doit être du texte.',
             'date'                   => 'Le champ :attribute doit être une date valide.',
             'date_fin.after_or_equal'=> 'La date de fin doit être après ou égale à la date de début.',
             '*.max'                  => 'Le champ :attribute ne doit pas dépasser :max caractères.',
         ];
     }
}