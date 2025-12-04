@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-success mb-3">Paiement réussi !</h3>
                    <p class="mb-4">Votre paiement a été traité avec succès. Vous pouvez maintenant télécharger votre CV.</p>               
                    <form action="{{ route('payment.confirm') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg mb-3">
                            <a href="{{ route('templates.template') }}">Télécharger mon CV</a>
                            <i class="fas fa-download"></i> 
                        </button>
                    </form>
                    payment-success
                    <a href="{{ route('cv.moncv') }}" class="btn btn-outline-primary">
                        Retour à la page principale
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 