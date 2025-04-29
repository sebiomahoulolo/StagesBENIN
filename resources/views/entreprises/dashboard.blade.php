@extends('layouts.entreprises.master')
@section('content')
<h1 class="page-title">Tableau de bord</h1>

<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">Actualités</div>
            <div class="stat-label">28</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">CV Thèque</div>
            <div class="stat-label">100 Postulants</div>
            <a href="">
                <div class="trend up">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-handshake"></i>
        </div>
        <div class="stat-info">
            <a href="{{ route('entreprises.annonces.index') }}">
                <div class="stat-value">Créer une annonce</div>
                <div class="trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>Publier vos annonces ici</span>
                </div>
            </a>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon red">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">Messagerie</div>
            <a href="">
                <div class="trend down">
                    <i class="fas fa-arrow-down"></i>
                    <span>Envoyez un message ou faites une publication</span>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="recent-applications">
        <div class="widget-header">
            <h2 class="widget-title">Annonces récentes</h2>
            <a href="{{ route('entreprises.annonces.index') }}" class="widget-action">
                Voir tout
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        @forelse($annonces as $annonce)
            <div class="application-item">
                <div class="application-position">
                    <div class="position-title">{{ $annonce->nom_du_poste }}</div>
                    <div class="position-info">
                        <span><i class="fas fa-map-marker-alt"></i> {{ $annonce->lieu }}</span>
                        <span><i class="fas fa-clock"></i> {{ $annonce->type_de_poste }}</span>
                        <span><i class="fas fa-calendar-alt"></i> Publié le {{ $annonce->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="application-count">
                    <a href="{{ route('entreprises.annonces.candidatures', $annonce) }}" class="text-decoration-none">
                        {{ $annonce->candidatures->count() }} candidatures
                    </a>
                </div>
                <div class="application-actions">
                    <a href="{{ route('entreprises.annonces.edit', $annonce) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('entreprises.annonces.destroy', $annonce) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <p>Aucune annonce publiée</p>
                <a href="{{ route('entreprises.annonces.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Créer une annonce
                </a>
            </div>
        @endforelse
    </div>

    <div class="upcoming-interviews">
        <div class="widget-header">
            <h2 class="widget-title">Entretiens à venir</h2>
            <a href="#" class="widget-action">
                Voir l'agenda
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        @forelse($entretiens as $entretien)
            <div class="interview-item">
                <div class="interview-date">
                    <i class="fas fa-calendar-day"></i>
                    <span>{{ $entretien->date->format('d/m/Y H:i') }}</span>
                </div>
                <div class="interview-position">{{ $entretien->annonce->nom_du_poste }}</div>
                <div class="interview-candidates">
                    <div class="candidate-tag">
                        <i class="fas fa-user"></i>
                        <span>{{ $entretien->candidature->etudiant->nom }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <p>Aucun entretien prévu</p>
            </div>
        @endforelse
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

    @forelse($activites as $activite)
        <div class="activity-item">
            <div class="activity-dot {{ $activite['type'] }}"></div>
            <div class="activity-content">
                <div class="activity-text">
                    {!! $activite['description'] !!}
                </div>
                <div class="activity-time">{{ $activite['created_at']->diffForHumans() }}</div>
            </div>
        </div>
    @empty
        <div class="text-center py-4">
            <p>Aucune activité récente</p>
        </div>
    @endforelse
</div>

@endsection

@push('styles')
<style>
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
    }

    .stat-icon.blue { background-color: #3498db; }
    .stat-icon.green { background-color: #2ecc71; }
    .stat-icon.orange { background-color: #f1c40f; }
    .stat-icon.red { background-color: #e74c3c; }

    .stat-info {
        flex: 1;
    }

    .stat-value {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    .trend {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8rem;
        margin-top: 5px;
    }

    .trend.up { color: #2ecc71; }
    .trend.down { color: #e74c3c; }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .widget-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .widget-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .widget-action {
        color: #3498db;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .application-item {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .position-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .position-info {
        display: flex;
        gap: 15px;
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    .position-info span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .application-count {
        font-weight: 600;
        color: #3498db;
    }

    .application-actions {
        display: flex;
        gap: 10px;
    }

    .interview-item {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .interview-date {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #3498db;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .interview-position {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .interview-candidates {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .candidate-tag {
        background: #f8f9fa;
        padding: 5px 10px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
    }

    .activity-feed {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .activity-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f0f2f5;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-top: 5px;
    }

    .activity-dot.blue { background-color: #3498db; }
    .activity-dot.green { background-color: #2ecc71; }
    .activity-dot.orange { background-color: #f1c40f; }
    .activity-dot.red { background-color: #e74c3c; }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .activity-time {
        font-size: 0.8rem;
        color: #7f8c8d;
    }
</style>
@endpush
