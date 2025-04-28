{{-- /resources/views/etudiants/boostage.blade.php --}}

{{-- Utilise le layout dédié aux étudiants --}}
@extends('layouts.etudiant.app')

{{-- Définit le titre spécifique pour cette page --}}
@section('title', 'Options de Boostage')

@push('styles')
    <style>
        /* Styles spécifiques pour la page de boostage */
        .boostage-header {
            padding: 1.5rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .boostage-header:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        
        .page-title {
            color: #2563eb;
            font-size: clamp(1.6rem, 4vw, 2rem);
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .section-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .section-container:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        
        .section-title {
            font-size: 1.25rem;
            color: #111827;
            margin-bottom: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 0.75rem;
            color: #2563eb;
        }
        
        /* Styles pour les étapes du processus */
        .process-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin: 2rem 0;
        }
        
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 10;
        }
        
        .step-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }
        
        .step-active {
            background-color: #2563eb;
            color: white;
        }
        
        .step-inactive {
            background-color: #e5e7eb;
            color: #4b5563;
        }
        
        .step-label {
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
            max-width: 100px;
        }
        
        .progress-line {
            position: absolute;
            top: 24px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e5e7eb;
            z-index: 1;
        }
        
        .progress-line-active {
            position: absolute;
            top: 24px;
            left: 0;
            height: 2px;
            background-color: #2563eb;
            z-index: 2;
            width: 0%;
        }
        
        /* Styles pour les avantages */
        .advantages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .advantage-item {
            display: flex;
            align-items: flex-start;
        }
        
        .advantage-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            background-color: #2563eb;
            color: white;
        }
        
        .advantage-icon i {
            font-size: 1.1rem;
        }
        
        .advantage-content h3 {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #1f2937;
        }
        
        .advantage-content p {
            color: #6b7280;
            font-size: 0.95rem;
        }
        
        /* Styles pour les témoignages */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .testimonial-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        
        .testimonial-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            margin-right: 1rem;
        }
        
        .testimonial-author h3 {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #1f2937;
        }
        
        .testimonial-author p {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .testimonial-rating {
            display: flex;
            margin-top: 1rem;
        }
        
        .testimonial-rating i {
            color: #fbbf24;
            margin-right: 0.25rem;
        }
        
        /* Styles pour la FAQ */
        .faq-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .faq-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
        }
        
        .faq-item h3 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1f2937;
        }
        
        .faq-item p {
            color: #6b7280;
        }
        
        /* Palette de couleurs */
        .color-blue {
            background-color: #2563eb;
            color: white;
        }
        
        .color-green {
            background-color: #10b981;
            color: white;
        }
        
        .color-orange {
            background-color: #f59e0b;
            color: white;
        }
        
        .color-purple {
            background-color: #8b5cf6;
            color: white;
        }
        
        .color-red {
            background-color: #ef4444;
            color: white;
        }
        
        .color-teal {
            background-color: #14b8a6;
            color: white;
        }
    </style>
@endpush

{{-- Début de la section de contenu qui sera injectée dans le @yield('content') du layout --}}
@section('content')
    <div class="container mx-auto px-4 py-6">
        {{-- En-tête de la page --}}
        <div class="boostage-header">
            <h1 class="page-title"><i class="fas fa-rocket mr-2"></i>Boostez votre visibilité</h1>
            <p>Augmentez vos chances d'être repéré par les recruteurs avec nos options de boostage</p>
        </div>

        {{-- Étapes du processus --}}
        <div class="section-container">
            <h2 class="section-title"><i class="fas fa-tasks"></i>Processus de boostage</h2>
            
            <div class="process-steps">
                <div class="progress-line"></div>
                <div class="progress-line-active" style="width: 0%"></div>
                
                <div class="step-item">
                    <div class="step-circle step-active">1</div>
                    <div class="step-label">Choisir une option</div>
                </div>
                
                <div class="step-item">
                    <div class="step-circle step-inactive">2</div>
                    <div class="step-label">Consulter les détails</div>
                </div>
                
                <div class="step-item">
                    <div class="step-circle step-inactive">3</div>
                    <div class="step-label">Procéder au paiement</div>
                </div>
                
                <div class="step-item">
                    <div class="step-circle step-inactive">4</div>
                    <div class="step-label">Confirmation</div>
                </div>
                
                <div class="step-item">
                    <div class="step-circle step-inactive">5</div>
                    <div class="step-label">Profil boosté</div>
                </div>
            </div>
        </div>

        {{-- Avantages du boostage --}}
        <div class="section-container" style="background-color: #EFF6FF;">
            <h2 class="section-title"><i class="fas fa-star"></i>Avantages du boostage</h2>
            
            <div class="advantages-grid">
                <div class="advantage-item">
                    <div class="advantage-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="advantage-content">
                        <h3>Visibilité accrue</h3>
                        <p>Votre profil sera mis en avant dans les recherches des recruteurs.</p>
                    </div>
                </div>
                
                <div class="advantage-item">
                    <div class="advantage-icon color-green">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="advantage-content">
                        <h3>Candidatures prioritaires</h3>
                        <p>Vos candidatures seront traitées en priorité par les entreprises.</p>
                    </div>
                </div>
                
                <div class="advantage-item">
                    <div class="advantage-icon color-orange">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="advantage-content">
                        <h3>Badge premium</h3>
                        <p>Un badge premium sera affiché sur votre profil et vos candidatures.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Composant Livewire des options de boostage --}}
        <div class="section-container">
            <h2 class="section-title"><i class="fas fa-tags"></i>Choisissez votre option</h2>
            @livewire('boost-options-component')
        </div>

        {{-- Témoignages --}}
        <!-- <div class="section-container">
            <h2 class="section-title"><i class="fas fa-quote-left"></i>Ce que disent nos utilisateurs</h2>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar color-blue">JD</div>
                        <div class="testimonial-author">
                            <h3>Jean Dupont</h3>
                            <p>Étudiant en informatique</p>
                        </div>
                    </div>
                    <p>"Grâce au boostage de mon profil, j'ai reçu trois fois plus de propositions d'entretien qu'avant. C'est un investissement qui a vraiment valu la peine pour ma recherche de stage."</p>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar color-green">AT</div>
                        <div class="testimonial-author">
                            <h3>Aminata Touré</h3>
                            <p>Étudiante en marketing</p>
                        </div>
                    </div>
                    <p>"Le badge premium a vraiment fait la différence. Les recruteurs m'ont dit qu'ils avaient remarqué mon profil grâce au boostage. J'ai décroché mon stage idéal en moins de deux semaines !"</p>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar color-purple">PK</div>
                        <div class="testimonial-author">
                            <h3>Paul Kouassi</h3>
                            <p>Étudiant en génie civil</p>
                        </div>
                    </div>
                    <p>"J'étais sceptique au début, mais le boostage a vraiment fonctionné pour moi. Mon profil est apparu en tête des recherches et j'ai reçu beaucoup plus de visites qu'avant."</p>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
        </div> -->

        {{-- FAQ --}}
        <div class="section-container">
            <h2 class="section-title"><i class="fas fa-question-circle"></i>Questions fréquentes</h2>
            
            <div class="faq-container">
                <div class="faq-item">
                    <h3>Combien de temps dure un boostage ?</h3>
                    <p>Le boostage dure 30 jours à partir de la date d'activation. Vous pouvez renouveler à tout moment.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Puis-je annuler mon boostage ?</h3>
                    <p>Une fois activé, le boostage ne peut pas être annulé. Cependant, vous pouvez choisir de ne pas le renouveler à la fin de la période.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Quels sont les modes de paiement acceptés ?</h3>
                    <p>Nous acceptons les paiements par carte bancaire, mobile money (MTN, Orange, Moov), et transfert bancaire.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Comment savoir si mon boostage est actif ?</h3>
                    <p>Un badge "Profil Boosté" apparaîtra sur votre profil. Vous pouvez également vérifier le statut et la durée restante dans la section "Mon compte".</p>
                </div>
            </div>
        </div>
    </div>
@endsection 