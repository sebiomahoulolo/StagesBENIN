@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
 {{-- Boutons d'action --}}
    <div class="d-flex gap-2 mt-4">
        <a href="{{--mailto:{{ $entreprise->email }}{{----}}" class="btn btn-primary">
            <i class="fas fa-envelope"></i> Contacter par Email
        </a>

        <a href="{{--{{ route('entreprises.message', $entreprise->id) }}--}}" class="btn btn-success">
            <i class="fas fa-comment-dots"></i> Envoyer un Message
        </a>
    </div>
<div class="content-area">

    <h4>Informations sur l'entreprise : {{ $entreprise->nom }}</h4>

    <table class="table table-bordered">
        <tr>
            <th>Nom</th>
            <td>{{ $entreprise->nom }}</td>
        </tr>
        <tr>
            <th>Secteur</th>
            <td>{{ $entreprise->secteur ?? '-' }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $entreprise->description ?? '-' }}</td>
        </tr>
        <tr>
            <th>Adresse</th>
            <td>{{ $entreprise->adresse ?? '-' }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $entreprise->email }}</td>
        </tr>
        <tr>
            <th>Téléphone</th>
            <td>{{ $entreprise->telephone ?? '-' }}</td>
        </tr>
        <tr>
            <th>Site Web</th>
            <td>
                @if ($entreprise->site_web)
                    <a href="{{ $entreprise->site_web }}" target="_blank">{{ $entreprise->site_web }}</a>
                @else
                    <span class="text-muted">Non spécifié</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Logo</th>
            <td>
                @if ($entreprise->logo_path && Storage::exists($entreprise->logo_path))
                    <img src="{{ Storage::url($entreprise->logo_path) }}" alt="Logo {{ $entreprise->nom }}" style="width:100px;height:100px; object-fit:contain;">
                @else
                    <span class="text-muted">Aucun logo disponible</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>PDG</th>
            <td>{{ $entreprise->contact_principal ?? '-' }}</td>
        </tr>
        <tr>
            <th>Date d'inscription</th>
            <td>{{ $entreprise->created_at ? $entreprise->created_at->format('d M Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Annonces disponibles</th>
            <td>{{ $nombre_annonces }} annonce(s)</td>
        </tr>
        <tr>
            <th>Présent dans le catalogue</th>
            <td>{{ $catalogue_existe }}</td>
        </tr>
        <tr>
            <th>Événements publiés</th>
            <td>{{ $nombre_evenements }} événement(s)</td>
        </tr>
    </table>

   
</div>
@endsection
