{{-- Vue mise à jour - resultats_pratique.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'StagesBENIN - Résultats des entretiens')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Résultats des entretiens Pratiques
                        </h3>
                        
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table">
                                <tr >
                                   <th scope="col">
                                       Nom & Prénom
                                    </th>
                                    <th scope="col">
                                       Niveau
                                    </th>
                                    <th scope="col">
                                      Formation
                                    </th>
                                    <th scope="col">
                                       Annonce d'entretiens
                                    </th>
                                    <th scope="col" class="text-center">
                                        </i>Note total
                                    </th>
                                    <th scope="col" class="text-center">
                                       Date Passage
                                    </th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($examens as $index => $examen)
                                    <tr class="align-middle">
                                     <td>
                                            <div class="d-flex align-items-center">
                                                
                                                <div>
                                                    <div class="fw-semibold">{{ $examen->etudiant->nom ?? 'N/A' }} {{ $examen->etudiant->prenom ?? '' }}</div>
                                                  
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <span class=" bg-info">{{ $examen->etudiant->niveau ?? 'N/A' }}</span>
                                        </td>
                                        
                                        <td>
                                            <span class="text-wrap">{{ $examen->etudiant->formation ?? 'N/A' }}</span>
                                        </td>
                                        
                                        <td>
                                            <span class="bg-secondary">{{ $examen->annonce->nom_du_poste ?? 'Non spécifié' }}</span>
                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="score-container">
                                                <span class=" fs-6 {{ $examen->score >= 5 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $examen->score }}/10
                                                </span>
                                                {{-- <div class="progress mt-1" style="height: 4px;">
                                                    <div class="progress-bar {{ $examen->score >= 5 ? 'bg-success' : 'bg-danger' }}" 
                                                         style="width: {{ ($examen->score / 10) * 100 }}%"></div>
                                                </div> --}}
                                            </div>
                                        </td>
                                        
                                        

                                        
                                        <td class="text-center">
                                            <div class="text-muted">
                                                
                                                {{ $examen->created_at->format('d/m/Y') }}
                                                <br>
                                                <small>{{ $examen->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Actions">
                                                <a href="{{ route('admin.cvtheque.view', $examen->etudiant->id) }}" 
                                                   class="btn btn-outline-info btn-sm" 
                                                   title="Voir le CV" 
                                                   data-bs-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.examens.noter', $examen->id) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="Voir les détails" 
                                                   data-bs-toggle="tooltip">
                                                    <i class="fas fa-info-circle"></i> Noter
                                                </a>
                                                @if(isset($examen->note_pratique))
                                                    <button type="button" 
                                                            class="btn btn-outline-warning btn-sm" 
                                                            title="Modifier la note" 
                                                            data-bs-toggle="tooltip"
                                                            onclick="openEditModal({{ $examen->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <h5>Aucun entretien trouvé</h5>
                                                <p>Il n'y a pas encore d'entretiens pratiques enregistrés.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($examens->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Affichage de {{ $examens->firstItem() }} à {{ $examens->lastItem() }} 
                                sur {{ $examens->total() }} résultats
                            </div>
                            {{ $examens->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection

{{-- Scripts pour améliorer l'expérience utilisateur --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Animation des badges au survol
    document.querySelectorAll('.badge').forEach(function(badge) {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Animation des cartes de statistiques
    document.querySelectorAll('.card').forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Confirmation pour les actions sensibles
    document.querySelectorAll('form[action*="supprimer"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir effectuer cette action ? Cette opération est irréversible.')) {
                e.preventDefault();
            }
        });
    });

    // Fonction pour filtrer le tableau
    function filterTable() {
        // Implémentation du filtrage si nécessaire
    }

    // Gestion de l'impression
    window.addEventListener('beforeprint', function() {
        document.body.classList.add('printing');
    });

    window.addEventListener('afterprint', function() {
        document.body.classList.remove('printing');
    });
});

// Fonction pour ouvrir le modal d'édition
function openEditModal(examenId) {
    // Implémentation du modal d'édition
    console.log('Ouvrir modal pour examen ID:', examenId);
}
</script>
@endsection