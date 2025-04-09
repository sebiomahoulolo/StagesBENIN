{{-- Utilisation du layout Guest de Breeze --}}
<x-guest-layout>
    <form method="POST" action="{{ route('register.etudiant.store') }}">
        @csrf

        <h2 style="text-align: center; margin-bottom: 1.5rem; color: #333;">Inscription Étudiant</h2>

         {{-- Affichage des erreurs générales (optionnel) --}}
         @if (session('error'))
             <div style="color: red; margin-bottom: 1rem; text-align: center;">{{ session('error') }}</div>
         @endif

        <!-- Prénom -->
        <div>
            <x-input-label for="prenom" :value="__('Prénom')" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        <!-- Nom -->
        <div class="mt-4">
            <x-input-label for="nom" :value="__('Nom')" />
            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

         {{-- Champs spécifiques étudiant (Optionnels ici, peuvent être sur le profil) --}}
          <div class="mt-4">
            <x-input-label for="telephone" :value="__('Téléphone (Optionnel)')" />
            <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>
         <div class="mt-4">
            <x-input-label for="formation" :value="__('Formation Actuelle (Optionnel)')" />
            <x-text-input id="formation" class="block mt-1 w-full" type="text" name="formation" :value="old('formation')" />
            <x-input-error :messages="$errors->get('formation')" class="mt-2" />
        </div>
         {{-- Ajoutez d'autres champs si nécessaire (niveau, date naissance...) --}}


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Déjà inscrit?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('S\'inscrire comme Étudiant') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
             <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register.recruteur.create') }}">
                {{ __('S\'inscrire comme Recruteur ?') }}
            </a>
        </div>
    </form>
</x-guest-layout>