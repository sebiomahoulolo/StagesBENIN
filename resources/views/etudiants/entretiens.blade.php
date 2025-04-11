@extends('layouts.app')

@section('content')
<style>
    .container {
        max-width: 1100px;
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

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px;
        border: 1px solid #ced4da;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .result-container {
        padding: 20px;
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .score {
        font-size: 28px;
        font-weight: bold;
        color: #28a745;
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

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: black;
    }

    .btn-warning:hover {
        background-color: #e0a800;
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
    <h1 class="section-title">📅 Planifier un Entretien</h1>

    <div class="row">
        <!-- Colonne de gauche : Formulaire d'entretien -->
        <div class="col-md-6">
            <form action="{{ route('etudiants.entretiens', ['etudiant_id' => $etudiant->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">

                <div class="form-group">
                    <label for="date" class="form-label">Date de l'entretien :</label>
                    <input type="datetime-local" name="date" id="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="lieu" class="form-label">Lieu :</label>
                    <input type="text" name="lieu" id="lieu" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="commentaires" class="form-label">Commentaires :</label>
                    <textarea name="commentaires" id="commentaires" rows="4" class="form-control"></textarea>
                </div>

                <div class="btn-group">
                    
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        📅 Confirmer l'entretien
                    </button>
                </div>
            </form>
        </div>

        <!-- Colonne de droite : Résultats de l'entretien -->
        <!-- Résultats de l'entretien -->
<div class="col-md-6">
    <div class="result-container">
        <h2 class="text-center">📊 Résultats de l’Entretien</h2>

        <table class="table table-striped table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 40%;">🏷️ Informations</th>
                    <th style="width: 60%;">📊 Valeurs</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Nom du candidat :</strong></td>
                    <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                </tr>

                @if($examen)
                    <tr>
                        <td><strong>Score obtenu :</strong></td>
                        <td class="text-success"><strong>{{ $examen->score }} / {{ $examen->total_questions }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Entreprise évaluatrice :</strong></td>
                        <td>{{ $entreprise ? $entreprise->nom : 'Non renseignée' }}</td>
                    </tr>
                    
                @else
                    <tr>
                        <td colspan="2" class="text-danger"><strong>⚠️ Aucun résultat disponible pour cet entretien.</strong></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

    </div>
</div>
@endsection
