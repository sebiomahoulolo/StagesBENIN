@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @php
                        $user = Auth::user();
                    @endphp
                    @if($user && $user->estAbonneActif())
                        <form method="POST" action="{{ route('cv.telecharger') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-lg w-100 mb-2">
                                Télécharger mon CV (abonnement actif)
                            </button>
                        </form>
                        <small class="text-success">
                            Téléchargement illimité jusqu'au {{ $user->abonnement->date_fin->format('d/m/Y') }}
                        </small>
                    @else
                        @if($downloadsRestants > 0 && !session('error'))
                            <form method="POST" action="{{ route('templates.template') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-lg w-100 mb-2">
                                    Télécharger ({{ $downloadsRestants }} téléchargement{{ $downloadsRestants <= 1 ? '' : 's' }} restant{{ $downloadsRestants <= 1 ? '' : 's' }})
                                </button>
                            </form>
                            <small class="text-muted">
                                Vous pouvez encore télécharger votre CV {{ $downloadsRestants }} fois.
                            </small>
                        @else
                            <div class="alert alert-warning mb-3">
                            Pour continuer à télécharger votre CV, veuillez effectuer un paiement.
                            </div>
                            <a href="https://me.fedapay.com/Ol_Zva4W" target="_blank" class="btn btn-success btn-lg w-100 mb-2">
                                <i class="fas fa-credit-card"></i> Payer pour 3 téléchargements
                            </a>
                            <small class="text-muted">
                                Après le paiement, vous pourrez télécharger votre CV 3 fois.
                            </small>
                        @endif
                    @endif
                    
                   @if(session('error'))
                        <div class="alert alert-danger mt-2">
                            {{ session('error') }}<br>
                            <span class="text-danger">Veuillez effectuer le paiement pour continuer. Merci !</span>
                        </div>
                    @endif 
                @if(session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div> 

 <div class="card shadow-sm">
                <div class="card-body text-center">
  
                       <a href="{{ route('cv.lettre_motivation') }}" class="btn btn-secondary btn-lg w-100">
            Voir ma lettre de motivation et télécharger
        </a>
                </div>
            </div>

<br>
            <div class="card shadow-sm">
                <div class="card-body text-center">
              
                    <a href="{{ route('cv.index') }}" class="btn btn-success btn-lg w-100">
                        Créer un nouveau CV
                    </a>
                </div>
            </div>
         
        </div>
    </div>
</div>
@endsection
