@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
    @section('content')

<style>
    .container {
        max-width: 850px;
        margin: auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 24px;
        font-weight: bold;
        color: #212529;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 16px;
        align-items: center;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        text-align: right;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px;
        border: 1px solid #ced4da;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 4px rgba(40, 167, 69, 0.3);
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: bold;
        transition: all 0.2s ease-in-out;
    }

    .btn-outline-danger {
        border: 2px solid #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #218838;
    }
</style>

<div class="container">
    <h1 class="section-title">Modifier l'Événement</h1>

    <form action="{{ route('evenements.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <label for="title" class="form-label">Titre :</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $event->title }}" required>

            <label for="start_date" class="form-label">Date de début :</label>
            <input type="datetime-local" name="start_date" id="start_date" class="form-control"
                value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') }}" required>

            <label for="end_date" class="form-label">Date de fin :</label>
            <input type="datetime-local" name="end_date" id="end_date" class="form-control"
                value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') }}" required>

            <label for="location" class="form-label">Lieu :</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $event->location }}">

            <label for="type" class="form-label">Type d'événement :</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ $event->type }}">

            <label for="description" class="form-label">Description :</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ $event->description }}</textarea>
        </div>

        <div class="btn-group">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">
                ❌ Annuler
            </a>
            <button type="submit" class="btn btn-success">
                 Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

      @endsection
    @push('scripts')
        {{-- Scripts spécifiques si besoin --}}
    @endpush
