<?php

namespace App\Http\Requests\Etudiant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateFormationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ici, on pourrait vérifier que l'utilisateur possède bien la formation qu'il essaie de modifier
        // $formation = Formation::find($this->route('id')); // Ou $this->route('formation') si paramètre nommé différemment
        // return Auth::check() && $formation && $formation->cvProfile->etudiant_id === Auth::user()->etudiant->id;
        return Auth::check(); // Simplifié pour l'instant
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Les règles sont généralement les mêmes que pour la création
         $currentYear = date('Y');
         return [
             'diplome'       => 'required|string|max:255',
             'etablissement' => 'required|string|max:255',
             'ville'         => 'nullable|string|max:100',
             'annee_debut'   => 'required|integer|digits:4|min:1950|max:' . ($currentYear + 2),
             'annee_fin'     => 'nullable|integer|digits:4|min:1950|max:' . ($currentYear + 6) . '|gte:annee_debut',
             'description'   => 'nullable|string|max:2000',
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
             'required'    => 'Le champ :attribute est obligatoire.',
             'string'      => 'Le champ :attribute doit être du texte.',
             'integer'     => 'L\'année doit être un nombre.',
             'digits'      => 'L\'année doit contenir 4 chiffres (YYYY).',
             'min'         => 'L\'année ne peut pas être avant :min.',
             'max'         => 'L\'année ne peut pas être après :max.',
             'annee_fin.gte' => 'L\'année de fin doit être supérieure ou égale à l\'année de début.',
             '*.max'       => 'Le champ :attribute ne doit pas dépasser :max caractères.',
         ];
     }
}