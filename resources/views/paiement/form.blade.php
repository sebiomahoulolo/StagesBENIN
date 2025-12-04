@extends('layouts.layout')

@section('title', 'Paiement FedaPay')

@section('content')
<br><br><br><br>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="mb-4 text-center">Récapitulatif de paiement</h3>
                    <p><strong>Nom :</strong> {{ $etudiant->prenom }} {{ $etudiant->nom }}</p>
                    <p><strong>Email :</strong> {{ $etudiant->email }}</p>
                    <p><strong>Formule :</strong> {{ ucfirst($formule) }}</p>
                    <p><strong>Montant :</strong> {{ number_format($montant, 0, ',', ' ') }} XOF</p>
                    <form action="{{ route('paiement.feadapay') }}" method="post">
                        @csrf
                        <input type="hidden" name="etudiant" value="{{ $etudiant->id }}">
                        <input type="hidden" name="formule" value="{{ $formule }}">
                        <button type="submit" class="btn btn-success w-100">Payer maintenant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 