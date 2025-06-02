@extends('layouts.layout')

{{-- Définit le titre spécifique de la page --}}
@section('title', 'Connexion - StagesBENIN')

{{-- Injecte les styles spécifiques pour cette page --}}
@section('styles')

<div class="mb-4 text-sm text-gray-600">
        {{ __('Ceci est une zone sécurisée. Veuillez confirmer votre mot de passe avant de continuer.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
{{-- Pas de scripts spécifiques nécessaires pour le login simple, mais on garde la section vide --}}
@section('scripts')
@endsection

