{{-- resources/views/entreprises/index.blade.php --}}
@extends('layouts.layout') {{-- Assurez-vous que c'est le bon layout --}}

@section('title', 'Tableau de Bord Entreprise')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Bienvenue sur votre Tableau de Bord, {{ Auth::user()->name }}!
    </h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <p class="text-gray-700">
            C'est ici que vous pourrez gérer vos informations d'entreprise, publier des offres de stage, consulter les candidatures, etc.
        </p>
        {{-- Ajoutez ici les composants ou le contenu du tableau de bord --}}

        <div class="mt-6">
            <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Publier une nouvelle offre
            </a>
             <a href="{{ route('entreprises.profil.edit') }}" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Modifier le profil de l'entreprise
             </a>
        </div>
    </div>
</div>
@endsection 