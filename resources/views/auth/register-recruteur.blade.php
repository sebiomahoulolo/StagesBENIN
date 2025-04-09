<x-guest-layout>
    <form method="POST" action="{{ route('register.recruteur.store') }}">
        @csrf

         <h2 style="text-align: center; margin-bottom: 1.5rem; color: #333;">Inscription Recruteur / Entreprise</h2>

         {{-- Affichage des erreurs générales (optionnel) --}}
          @if (session('error'))
              <div style="color: red; margin-bottom: 1rem; text-align: center;">{{ session('error') }}</div>
          @endif

         <h3 style="font-weight: bold; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Informations de Connexion (Contact)</h3>

        <!-- Name (Contact Person) -->
        <div>
            <x-input-label for="name" :value="__('Votre Nom Complet (Contact)')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address (Login) -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Votre Email de Connexion')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <h3 style="font-weight: bold; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Informations Entreprise</h3>

         <!-- Nom Entreprise -->
        <div class="mt-4">
            <x-input-label for="nom_entreprise" :value="__('Nom de l\'Entreprise')" />
            <x-text-input id="nom_entreprise" class="block mt-1 w-full" type="text" name="nom_entreprise" :value="old('nom_entreprise')" required />
            <x-input-error :messages="$errors->get('nom_entreprise')" class="mt-2" />
        </div>

         <!-- Email Entreprise -->
        <div class="mt-4">
            <x-input-label for="email_entreprise" :value="__('Email Public de l\'Entreprise')" />
            <x-text-input id="email_entreprise" class="block mt-1 w-full" type="email" name="email_entreprise" :value="old('email_entreprise')" required />
            <x-input-error :messages="$errors->get('email_entreprise')" class="mt-2" />
        </div>

         <!-- Telephone Entreprise -->
         <div class="mt-4">
            <x-input-label for="telephone_entreprise" :value="__('Téléphone Entreprise (Optionnel)')" />
            <x-text-input id="telephone_entreprise" class="block mt-1 w-full" type="tel" name="telephone_entreprise" :value="old('telephone_entreprise')" />
            <x-input-error :messages="$errors->get('telephone_entreprise')" class="mt-2" />
        </div>

         <!-- Secteur -->
         <div class="mt-4">
            <x-input-label for="secteur" :value="__('Secteur d\'activité (Optionnel)')" />
            <x-text-input id="secteur" class="block mt-1 w-full" type="text" name="secteur" :value="old('secteur')" />
            <x-input-error :messages="$errors->get('secteur')" class="mt-2" />
        </div>

         <!-- Adresse -->
         <div class="mt-4">
            <x-input-label for="adresse" :value="__('Adresse (Optionnel)')" />
            <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse')" />
            <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Déjà inscrit?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('S\'inscrire comme Recruteur') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
             <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register.etudiant.create') }}">
                {{ __('S\'inscrire comme Étudiant ?') }}
            </a>
        </div>
    </form>
</x-guest-layout>