<?php

namespace App\Http\Requests\Etudiant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjetRequest extends FormRequest
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
            'nom'           => 'required|string|max:255',
            'url_projet'    => 'nullable|url|max:500',
            'description'   => 'nullable|string|max:3000', // Limite Trix
            'technologies'  => 'nullable|string|max:255', // Liste de technos séparées par virgule?
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
              'url'         => 'Le champ :attribute doit être une URL valide.',
              '*.max'       => 'Le champ :attribute ne doit pas dépasser :max caractères.',
          ];
     }
}