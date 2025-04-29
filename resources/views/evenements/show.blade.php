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

<div class="container py-5">
    <div class="event-container">
        <h1 class="event-title">Détails de l'Événement</h1>

        <div class="event-details">
            <div class="event-label">Titre :</div>
            <div class="event-value">{{ $event->title }}</div>

            <div class="event-label">Date de début :</div>
            <div class="event-value">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}</div>

            <div class="event-label">Date de fin :</div>
            <div class="event-value">{{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}</div>

            <div class="event-label">Lieu :</div>
            <div class="event-value">{{ $event->location ?? '-' }}</div>

            <div class="event-label">Type :</div>
            <div class="event-value">{{ $event->type ?? '-' }}</div>

            <div class="event-label">Description :</div>
            <div class="event-value">{{ $event->description ?? '-' }}</div>

            <div class="event-label">Statut :</div>
            <div class="event-value">
                @if ($event->is_published)
                    <span class="badge bg-success">Publié</span>
                @else
                    <span class="badge bg-secondary">Privé</span>
                @endif
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('evenements.edit', $event->id) }}" class="btn btn-warning">
                 Modifier
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                 Retour
            </a>
        </div>
    </div>
</div>


      @endsection
    @push('scripts')
        {{-- Scripts spécifiques si besoin --}}
    @endpush
