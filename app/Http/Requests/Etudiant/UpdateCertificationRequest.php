<?php

namespace App\Http\Requests\Etudiant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCertificationRequest extends FormRequest
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
         $currentYear = date('Y');
         return [
             'nom'           => 'required|string|max:255',
             'organisme'     => 'required|string|max:255',
             'annee'         => 'nullable|integer|digits:4|min:1950|max:' . ($currentYear + 1),
             'url_validation'=> 'nullable|url|max:500',
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
               'url'         => 'Le champ :attribute doit être une URL valide.',
               '*.max'       => 'Le champ :attribute ne doit pas dépasser :max caractères.',
           ];
     }
}