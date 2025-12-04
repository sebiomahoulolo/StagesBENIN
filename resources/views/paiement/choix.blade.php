@extends('layouts.layout')

@section('title', 'Choix de la formule d\'abonnement')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register-etudiant.css') }}">
    <style>
        .formule-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        .formule-col {
            min-width: 0;
            max-width: 500px;
            width: 100%;
            margin-bottom: 0;
        }
        .formule-option {
            border: 2px solid #ddd;
            border-radius: 18px;
            padding: 40px;
            min-height: 520px;
            background: #fff;
            transition: box-shadow 0.2s, border-color 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .formule-option:hover {
            border-color: #48cae4;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        .formule-option.selected { border-color: #0077b6; background-color: #caf0f8; box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.2), 0 10px 20px rgba(0, 119, 182, 0.1); }
        .formule-title {
            font-size: 2.1rem;
            font-weight: 700;
            color: #0077b6;
            margin-bottom: 24px;
            text-align: center;
            text-decoration: none !important;
        }
        .formule-price {
            font-size: 2.3rem;
            font-weight: 800;
            margin-bottom: 28px;
            text-align: center;
            color: #023e8a;
            text-decoration: none !important;
        }
        .formule-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #dc3545;
            color: #fff;
            padding: 8px 18px;
            border-radius: 24px;
            font-size: 1.05rem;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(220,53,69,0.12);
            z-index: 2;
        }
        .avantage-list, .limitation-list { list-style-type: none; padding-left: 0; margin-bottom: 20px; flex-grow: 1; }
        .avantage-list li, .limitation-list li { margin-bottom: 12px; padding-left: 30px; position: relative; font-size: 1.05rem; line-height: 1.5; }
        .avantage-list li:before { content: "✓"; color: #28a745; font-weight: bold; position: absolute; left: 5px; font-size: 1.2rem; }
        .limitation-list li:before { content: "✗"; color: #dc3545; font-weight: bold; position: absolute; left: 5px; font-size: 1.2rem; }
        .formule-title, .formule-price, .avantage-list li, .limitation-list li {
            text-decoration: none !important;
        }
        @media (max-width: 991px) {
            .formule-container {
                flex-direction: column;
                gap: 1.5rem;
            }
            .formule-col {
                max-width: 100%;
            }
        }
        @media (max-width: 768px) { .formule-option { padding: 20px; min-height: auto; } .formule-title { font-size: 1.5rem; } .formule-price { font-size: 1.8rem; } .avantage-list li, .limitation-list li { font-size: 1rem; } }
    </style>
@endsection

@section('content')
<br><br><br><br>
<main id="content" class="site-main" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.7);">
    <section class="candidate-signup-section w-100">
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
            <div class="row w-100 justify-content-center">
                <div class="col-lg-10 col-md-12 col-sm-12">
                    <div class="signup-form-container p-4" style="background: rgba(255,255,255,0.95); border-radius: 24px; box-shadow: 0 8px 32px rgba(0,0,0,0.08);">
                        <h2 class="signup-form-title text-center mb-2">Choisissez votre formule</h2>
                        <p class="text-center mb-4">Sélectionnez l'option qui correspond le mieux à vos besoins</p>
                       
                        <div class="formule-section">
                            <div class="formule-container row gx-4 gy-4 justify-content-center">
                                <!-- Formule Simple -->
                                <div class="formule-col col-12 col-md-6 d-flex">
                                    <div class="formule-option flex-fill d-flex flex-column justify-content-between align-items-stretch shadow-sm">
                                        <div>
                                            <div class="formule-title mb-3" style="text-decoration: none;">Formule Simple</div>
                                            <div class="formule-price mb-3">500 FCFA/mois</div>
                                            <ul class="avantage-list mb-2" style="text-decoration: none;">
                                                <li>Accès complet à la plateforme</li>
                                                <li>Consultation des offres</li>
                                                <li>Possibilité de postuler aux offres</li>
                                                <li>Évaluation automatique des compétences</li>
                                                <li>Conseils basiques par email</li>
                                            </ul>
                                            <ul class="limitation-list mb-2" style="text-decoration: none;">
                                                <li>Coaching personnalisé non inclus</li>
                                                <li>Générateur de CV désactivé</li>
                                                <li>Profil invisible aux entreprises partenaires</li>
                                                <li>Pas de priorité sur les offres premium</li>
                                            </ul>
                                        </div>
                                        <a href="{{ route('paiement.form', ['etudiant' => $etudiant->id ?? request('etudiant'), 'formule' => 'simple']) }}" class="btn btn-primary mt-3 w-100">Choisir cette formule</a>
                                    </div>
                                </div>
                                <!-- Formule Premium -->
                                <div class="formule-col col-12 col-md-6 d-flex">
                                    <div class="formule-option flex-fill d-flex flex-column justify-content-between align-items-stretch shadow-sm position-relative">
                                        <div>
                                            <div class="formule-badge">Recommandé</div>
                                            <div class="formule-title mb-3" style="text-decoration: none;">Formule Premium</div>
                                            <div class="formule-price mb-3">5.000 FCFA/an</div>
                                            <ul class="avantage-list mb-2" style="text-decoration: none;">
                                                <li>Accès complet à la plateforme</li>
                                                <li>Consultation des offres</li>
                                                <li>Possibilité de postuler aux offres</li>
                                                <li>Évaluation automatique des compétences</li>
                                                <li>Conseils basiques par email</li>
                                                <li>Coaching personnalisé</li>
                                                <li>Générateur de CV professionnel</li>
                                                <li>Profil visible et promu auprès des partenaires</li>
                                                <li>Accès prioritaire aux offres premium</li>
                                            </ul>
                                        </div>
                                        <a href="{{ route('paiement.form', ['etudiant' => $etudiant->id ?? request('etudiant'), 'formule' => 'premium']) }}" class="btn btn-primary mt-3 w-100">Choisir cette formule</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
{{-- Plus de JS nécessaire, tout est géré par les liens GET --}}
@endsection 