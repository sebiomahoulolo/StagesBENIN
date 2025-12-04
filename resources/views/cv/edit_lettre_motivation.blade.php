@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Modifier ma lettre de motivation</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cv.lettre_motivation.download') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="lettre" class="form-label">Lettre de motivation</label>
                            <textarea name="lettre" id="lettre" rows="16" class="form-control" required>{{ old('lettre', $texte) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success">
                            Télécharger en version Word
                        </button>
                        <a href="{{ route('cv.lettre_motivation') }}" class="btn btn-secondary ms-2">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 