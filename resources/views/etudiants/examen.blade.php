@extends('layouts.app')

@section('content')
<style>
    .container {
        max-width: 750px;
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

    .question-container {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .form-check-label {
        font-weight: 500;
        color: #495057;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn {
        padding: 12px 18px;
        border-radius: 10px;
        font-weight: bold;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: #fff;
    }
</style>

<div class="container">
    <h1 class="section-title">📜 Examen QCM pour l'entretien</h1>

    <form action="{{ route('etudiants.examen.submit', ['etudiant_id' => $etudiant->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">

        @foreach ($questions as $index => $question)
    <div class="question-container">
        <p><strong>Question {{ $index + 1 }} :</strong> {{ $question->texte }}</p>

        @if (is_array($question->options)) <!-- Vérification ajoutée ici -->
            @foreach ($question->options as $option)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponses[{{ $question->id }}]" value="{{ $option }}" required>
                    <label class="form-check-label">{{ $option }}</label>
                </div>
            @endforeach
        @else
            <p class="text-danger">⚠️ Options non valides pour cette question.</p>
        @endif
    </div>
@endforeach


        <div class="btn-group">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                ✅ Soumettre le test
            </button>
        </div>
    </form>
</div>
@endsection
