<?php

namespace App\Http\Requests\Etudiant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateLangueRequest extends FormRequest
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
        $validLevels = ['Natif', 'Courant', 'Intermédiaire', 'Débutant', 'Notions'];
        return [
            'langue' => 'required|string|max:50',
            'niveau' => ['required', 'string', Rule::in($validLevels)],
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