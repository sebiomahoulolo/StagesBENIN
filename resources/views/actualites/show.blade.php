@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
    @section('content')




    
<style>
    .event-container {
        max-width: 900px;
        margin: auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .event-title {
        font-size: 24px;
        font-weight: bold;
        color: #212529;
        margin-bottom: 20px;
    }

    .event-details {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 16px;
        align-items: center;
    }

    .event-label {
        font-weight: 600;
        color: #495057;
        text-align: right;
    }

    .event-value {
        background-color: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 18px;
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #000;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>
<div class="container">
    <h1 class="fw-bold">{{ $actualite->titre }}</h1>
    <div class="mb-4">
        <small class="text-muted">Publié le {{ \Carbon\Carbon::parse($actualite->date_publication)->format('d/m/Y') }} par {{ $actualite->auteur }}</small>
    </div>
    <p>{{ $actualite->contenu }}</p>
    <img src="{{ asset($actualite->image_path) }}" alt="Image de l'actualité" class="img-fluid rounded shadow">
    <a href="" class="btn btn-secondary mt-3">Retour</a>
</div>


      @endsection
    @push('scripts')
        {{-- Scripts spécifiques si besoin --}}
    @endpush
