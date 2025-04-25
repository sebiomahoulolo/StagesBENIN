@extends('layouts.entreprises.master')
@section('content')
<h1 class="page-title">Tableau de bord</h1>

@livewire('entreprise.dashboard')

<div class="dashboard-grid">
    <div class="recent-applications">
        <div class="widget-header">
            <h2 class="widget-title">Annonces récentes</h2>
            <a href="#" class="widget-action">
                Voir tout
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        <div class="application-item">
            <div class="application-position">
                <div class="position-title">Développeur Full Stack</div>
                <div class="position-info">
                    <span><i class="fas fa-map-marker-alt"></i> Paris</span>
                    <span><i class="fas fa-clock"></i> CDI</span>
                    <span><i class="fas fa-calendar-alt"></i> Publié il y a 2 jours</span>
                </div>
            </div>
            <div class="application-count">32</div>
            <div class="application-actions">
                <button><i class="fas fa-edit"></i></button>
                <button><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>

        <div class="application-item">
            <div class="application-position">
                <div class="position-title">Chef de Projet Digital</div>
                <div class="position-info">
                    <span><i class="fas fa-map-marker-alt"></i> Lyon</span>
                    <span><i class="fas fa-clock"></i> CDI</span>
                    <span><i class="fas fa-calendar-alt"></i> Publié il y a 3 jours</span>
                </div>
            </div>
            <div class="application-count">18</div>
            <div class="application-actions">
                <button><i class="fas fa-edit"></i></button>
                <button><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>

        <div class="application-item">
            <div class="application-position">
                <div class="position-title">Responsable Marketing</div>
                <div class="position-info">
                    <span><i class="fas fa-map-marker-alt"></i> Paris</span>
                    <span><i class="fas fa-clock"></i> CDD 6 mois</span>
                    <span><i class="fas fa-calendar-alt"></i> Publié il y a 5 jours</span>
                </div>
            </div>
            <div class="application-count">24</div>
            <div class="application-actions">
                <button><i class="fas fa-edit"></i></button>
                <button><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>

        <div class="application-item">
            <div class="application-position">
                <div class="position-title">UI/UX Designer</div>
                <div class="position-info">
                    <span><i class="fas fa-map-marker-alt"></i> Marseille</span>
                    <span><i class="fas fa-clock"></i> CDI</span>
                    <span><i class="fas fa-calendar-alt"></i> Publié il y a 1 semaine</span>
                </div>
            </div>
            <div class="application-count">15</div>
            <div class="application-actions">
                <button><i class="fas fa-edit"></i></button>
                <button><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
    </div>

    <div class="upcoming-interviews">
        <div class="widget-header">
            <h2 class="widget-title">Entretiens à venir</h2>
            <a href="#" class="widget-action">
                Voir l'agenda
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        <div class="interview-item">
            <div class="interview-date">
                <i class="fas fa-calendar-day"></i>
                <span>Aujourd'hui, 14:00 - 15:30</span>
            </div>
            <div class="interview-position">Développeur Full Stack</div>
            <div class="interview-candidates">
                <div class="candidate-tag">
                    <i class="fas fa-user"></i>
                    <span>Thomas D.</span>
                </div>
                <div class="candidate-tag">
                    <i class="fas fa-user"></i>
                    <span>Marie L.</span>
                </div>
            </div>
        </div>

        <div class="interview-item">
            <div class="interview-date">
                <i class="fas fa-calendar-day"></i>
                <span>Demain, 10:00 - 11:00</span>
            </div>
            <div class="interview-position">Chef de Projet Digital</div>
            <div class="interview-candidates">
                <div class="candidate-tag">
                    <i class="fas fa-user"></i>
                    <span>Alexandre F.</span>
                </div>
            </div>
        </div>

        <div class="interview-item">
            <div class="interview-date">
                <i class="fas fa-calendar-day"></i>
                <span>05/04/2025, 15:00 - 16:00</span>
            </div>
            <div class="interview-position">Responsable Marketing</div>
            <div class="interview-candidates">
                <div class="candidate-tag">
                    <i class="fas fa-user"></i>
                    <span>Sophie M.</span>
                </div>
                <div class="candidate-tag">
                    <i class="fas fa-user"></i>
                    <span>Paul G.</span>
                </div>
                <div class="candidate-tag">
                    <i class="fas fa-user"></i>
                    <span>Juliette R.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="activity-feed">
    <div class="widget-header">
        <h2 class="widget-title">Activité récente</h2>
        <a href="#" class="widget-action">
            Voir toutes les activités
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>

    <div class="activity-item">
        <div class="activity-dot blue"></div>
        <div class="activity-content">
            <div class="activity-text">
                <strong>Thomas M.</strong> a postulé pour le poste de <strong>Développeur Full Stack</strong>
            </div>
            <div class="activity-time">Il y a 35 minutes</div>
        </div>
    </div>

    <div class="activity-item">
        <div class="activity-dot green"></div>
        <div class="activity-content">
            <div class="activity-text">
                <strong>Vous</strong> avez publié une nouvelle offre : <strong>Responsable Commercial</strong>
            </div>
            <div class="activity-time">Il y a 2 heures</div>
        </div>
    </div>

    <div class="activity-item">
        <div class="activity-dot orange"></div>
        <div class="activity-content">
            <div class="activity-text">
                <strong>Marie L.</strong> a accepté l'invitation à l'entretien pour le poste de <strong>Développeur Full Stack</strong>
            </div>
            <div class="activity-time">Il y a 3 heures</div>
        </div>
    </div>

    <div class="activity-item">
        <div class="activity-dot red"></div>
        <div class="activity-content">
            <div class="activity-text">
                <strong>Alexandre F.</strong> a demandé un report de son entretien pour le poste de <strong>Chef de Projet Digital</strong>
            </div>
            @endsection