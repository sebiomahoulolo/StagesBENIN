@extends('layouts.layout')

@section('title', 'Récapitulatif de paiement')

@section('content')
<br><br><br><br><br><br>
<main id="content" class="site-main">
    <section class="candidate-signup-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="signup-form-container">
                        <h2 class="signup-form-title text-center">Récapitulatif de paiement</h2>
                        <div class="card p-4 mb-4">
                            <h5>Informations de l'étudiant</h5>
                            <ul class="list-unstyled mb-3">
                                <li><strong>Nom :</strong> {{ $etudiant->prenom }} {{ $etudiant->nom }}</li>
                                <li><strong>Email :</strong> {{ $etudiant->email }}</li>
                                <li><strong>Téléphone :</strong> {{ $etudiant->telephone }}</li>
                            </ul>
                            <h5>Formule choisie</h5>
                            <ul class="list-unstyled mb-3">
                                <li><strong>Formule :</strong> {{ $formule == 'premium' ? 'Premium (365 jours)' : 'Simple (30 jours)' }}</li>
                                <li><strong>Montant :</strong> {{ number_format($montant, 0, ',', ' ') }} XOF</li>
                            </ul>
                        </div>
                        <form method="POST" action="{{ route('paiement.feadapay') }}">
                            @csrf
                            <input type="hidden" name="etudiant" value="{{ $etudiant->id }}">
                            <input type="hidden" name="formule" value="{{ $formule }}">
                            <button type="submit" class="btn btn-primary w-100">Procéder au paiement</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection 