@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Détails de la demande</h1>
            <p class="text-gray-600">{{ $demande->entreprise->nom }}</p>
        </div>
        <a href="{{ route('admin.demandes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            Retour à la liste
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Informations de base --}}
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Informations générales</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type de demande</label>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $demande->type_demande === 'employe' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($demande->type_demande) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Poste</label>
                                <p class="mt-1 text-gray-900">{{ $demande->poste }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre de postes</label>
                                <p class="mt-1 text-gray-900">{{ $demande->nombre_postes }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Niveau d'études requis</label>
                                <p class="mt-1 text-gray-900">{{ $demande->niveau_etude }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Détails du poste --}}
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Détails du poste</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type de contrat</label>
                                <p class="mt-1 text-gray-900">{{ $demande->type_contrat }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lieu de travail</label>
                                <p class="mt-1 text-gray-900">{{ $demande->lieu_travail }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de début souhaitée</label>
                                <p class="mt-1 text-gray-900">{{ $demande->date_debut_souhaitee->format('d/m/Y') }}</p>
                            </div>
                            @if($demande->salaire_propose)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Salaire proposé</label>
                                    <p class="mt-1 text-gray-900">{{ number_format($demande->salaire_propose, 0, ',', ' ') }} FCFA</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description et compétences --}}
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Description du poste</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        {!! nl2br(e($demande->description_poste)) !!}
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2">Compétences requises</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        {!! nl2br(e($demande->competences_requises)) !!}
                    </div>
                </div>
            </div>

            {{-- Expérience et avantages --}}
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Expérience requise</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        {!! nl2br(e($demande->experience_requise)) !!}
                    </div>
                </div>

                @if($demande->avantages)
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Avantages proposés</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            {!! nl2br(e($demande->avantages)) !!}
                        </div>
                    </div>
                @endif
            </div>

            {{-- Section d'action administrative --}}
            @if($demande->statut === 'en_attente')
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Action administrative</h3>
                    <form action="{{ route('admin.demandes.updateStatus', $demande) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700">Changer le statut</label>
                            <select name="statut" id="statut" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="approuvee">Approuver</option>
                                <option value="rejetee">Rejeter</option>
                                <option value="en_cours">Marquer en cours</option>
                            </select>
                        </div>

                        <div>
                            <label for="commentaire_admin" class="block text-sm font-medium text-gray-700">Commentaire</label>
                            <textarea name="commentaire_admin" id="commentaire_admin" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="submit" name="statut" value="approuvee" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Approuver
                            </button>
                            <button type="submit" name="statut" value="rejetee" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Rejeter
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold mb-2">Statut actuel</h3>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @switch($demande->statut)
                                @case('approuvee') bg-green-100 text-green-800 @break
                                @case('rejetee') bg-red-100 text-red-800 @break
                                @case('en_cours') bg-blue-100 text-blue-800 @break
                            @endswitch
                        ">
                            {{ ucfirst($demande->statut) }}
                        </span>
                        @if($demande->commentaire_admin)
                            <span class="text-gray-600">{{ $demande->commentaire_admin }}</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection