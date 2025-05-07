@extends('layouts.admin.app')

@section('title', 'Gestion des Demandes d\'Employés - Administration')

@push('styles')
<style>
    /* Styles de base pour la page si non gérés par le layout admin global */
    body {
        /* background-color: #f4f6f9; */
        /* font-family: 'Inter', sans-serif; */
    }

    /* Améliorations spécifiques pour cette page */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem; /* 24px */
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb; /* Séparateur léger */
    }

    .page-title {
        font-size: 1.875rem; /* text-3xl */
        font-weight: 700; /* font-bold */
        color: #1f2937; /* gray-800 */
    }

    .content-card {
        background-color: #ffffff;
        border-radius: 0.75rem; /* rounded-xl */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-lg */
        overflow: hidden;
    }

    .table thead th {
        background-color: #f9fafb; /* bg-gray-50 */
        color: #6b7280; /* text-gray-500 */
        font-size: 0.75rem; /* text-xs */
        font-weight: 600; /* font-semibold */
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.75rem 1.5rem; /* py-3 px-6 */
        text-align: left;
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }

    .table tbody td {
        padding: 1rem 1.5rem; /* py-4 px-6 */
        white-space: nowrap;
        font-size: 0.875rem; /* text-sm */
        color: #374151; /* text-gray-700 */
        border-bottom: 1px solid #e5e7eb; /* divide-gray-200 */
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem; /* px-2.5 py-0.5 */
        border-radius: 9999px; /* rounded-full */
        font-size: 0.75rem; /* text-xs */
        font-weight: 500; /* font-medium */
        text-transform: capitalize;
    }
    .status-en_attente { background-color: #fef3c7; color: #92400e; }
    .status-approuvee { background-color: #d1fae5; color: #065f46; }
    .status-rejetee { background-color: #fee2e2; color: #991b1b; }
    .status-en_cours { background-color: #dbeafe; color: #1e40af; }

    .action-btn {
        padding: 0.375rem 0.625rem;
        border-radius: 0.375rem; /* rounded-md */
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        font-size: 0.875rem; /* text-sm */
        background: transparent; /* Important pour les boutons avec icônes seulement */
        border: none; /* Important pour les boutons avec icônes seulement */
        cursor: pointer; /* Assurer le curseur pointeur */
    }
    .action-btn i {
        font-size: 0.95rem; /* Augmenter légèrement la taille de l'icône */
    }
    .action-btn-view { color: #2563eb; }
    .action-btn-view:hover { background-color: #eff6ff; color: #1d4ed8;}
    .action-btn-approve { color: #16a34a; }
    .action-btn-approve:hover { background-color: #f0fdf4; color: #15803d; }
    .action-btn-reject { color: #dc2626; }
    .action-btn-reject:hover { background-color: #fef2f2; color: #b91c1c; }
    .action-btn-delete { color: #b91c1c; } /* Un rouge plus foncé pour la suppression */
    .action-btn-delete:hover { background-color: #fee2e2; color: #7f1d1d; }


    .alert-success {
        background-color: #ecfdf5;
        border-color: #a7f3d0;
        color: #059669;
        border-radius: 0.5rem;
    }
    .alert-error { /* Style pour les messages d'erreur */
        background-color: #fff5f5; /* red-50 */
        border-color: #fecaca; /* red-300 */
        color: #c53030; /* red-700 */
        border-radius: 0.5rem; /* rounded-lg */
    }

    .company-logo {
        height: 2.5rem; width: 2.5rem;
        border-radius: 9999px;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }
    .company-logo-placeholder {
        height: 2.5rem; width: 2.5rem;
        border-radius: 9999px;
        background-color: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .company-logo-placeholder i {
        color: #9ca3af;
        font-size: 1.25rem;
    }

    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .modal-content { /* Style de base pour le contenu du modal */
        background-color: #fff;
        padding: 1.5rem; /* p-6 */
        border-radius: 0.5rem; /* rounded-lg */
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); /* shadow-xl */
        width: 100%;
        max-width: 32rem; /* max-w-md */
        margin-left: auto;
        margin-right: auto;
    }
    .modal-overlay { /* Style pour le fond du modal */
        position: fixed;
        inset: 0;
        background-color: rgba(75, 85, 99, 0.5); /* bg-gray-600 bg-opacity-50 */
        overflow-y: auto;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50; /* Assurez-vous qu'il est au-dessus des autres contenus */
    }

</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="page-header">
        <h1 class="page-title">Gestion des Demandes d'Emploi</h1>
    </div>

    @if(session('success'))
        <div class="alert-success px-4 py-3 mb-6 rounded-md shadow" role="alert"> {{-- Ajout de rounded-md et shadow --}}
            <div class="flex">
                <div class="py-1"><i class="fas fa-check-circle mr-3"></i></div>
                <div>
                    <p class="font-bold">Succès</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error px-4 py-3 mb-6 rounded-md shadow" role="alert"> {{-- Ajout de rounded-md et shadow --}}
            <div class="flex">
                <div class="py-1"><i class="fas fa-exclamation-triangle mr-3"></i></div>
                <div>
                    <p class="font-bold">Erreur</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="content-card">
        <div class="table-container">
            <table class="min-w-full table">
                <thead>
                    <tr>
                        <th>Entreprise</th>
                        <th>Type Demande</th>
                        <th>Poste Recherché</th>
                        <th>Lieu</th>
                        <th>Statut</th>
                        <th>Date de Création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandes as $demande)
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    @if($demande->entreprise && $demande->entreprise->logo_path && Storage::disk('public')->exists($demande->entreprise->logo_path))
                                        <img class="company-logo" src="{{ Storage::url($demande->entreprise->logo_path) }}" alt="Logo {{ $demande->entreprise->nom ?? 'Entreprise' }}">
                                    @else
                                        <div class="company-logo-placeholder">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $demande->entreprise->nom ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $demande->entreprise->email ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $demande->type === 'emploi' ? 'bg-sky-100 text-sky-700' : 'bg-teal-100 text-teal-700' }}">
                                    {{ ucfirst($demande->type) }}
                                </span>
                            </td>
                            <td>
                                <div class="font-semibold text-gray-900">{{ $demande->titre }}</div>
                                <div class="text-xs text-gray-500">{{ $demande->nombre_postes }} poste(s)</div>
                            </td>
                            <td class="text-gray-600">
                                {{ $demande->lieu }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ $demande->statut }}">
                                    {{ str_replace('_', ' ', $demande->statut) }}
                                </span>
                            </td>
                            <td class="text-gray-600">
                                {{ $demande->created_at->format('d/m/Y') }}
                                <div class="text-xs text-gray-400">{{ $demande->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="flex items-center space-x-1">
                                    <a href="{{ route('admin.demandes.show', $demande) }}" class="action-btn action-btn-view" title="Voir Détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($demande->statut === 'en_attente')
                                        <form action="{{ route('admin.demandes.updateStatus', $demande) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="statut" value="approuvee">
                                            <button type="submit" class="action-btn action-btn-approve" title="Approuver">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="action-btn action-btn-reject" title="Rejeter"
                                                onclick="showRejectModal({{ $demande->id }})">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('admin.demandes.destroy', $demande) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette demande ?\nCette action est irréversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-btn-delete" title="Supprimer Définitivement">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-gray-400"></i>
                                    <p class="font-semibold">Aucune demande d'employé trouvée.</p>
                                    <p class="text-sm">Les nouvelles demandes apparaîtront ici.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Affichage de la pagination si $demandes est un objet Paginator --}}
        @if ($demandes instanceof \Illuminate\Pagination\LengthAwarePaginator && $demandes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $demandes->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Modal pour le motif de rejet --}}
<div id="rejectModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="flex justify-between items-center pb-3 mb-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Motif du Rejet</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-150">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>
        <form id="rejectForm" action="" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="statut" value="rejetee">
            <div>
                <label for="motif_rejet" class="block text-sm font-medium text-gray-700 mb-1">Motif (obligatoire si rejet) :</label>
                <textarea id="motif_rejet" name="motif_rejet" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Expliquez brièvement pourquoi la demande est rejetée..." required></textarea>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Confirmer le Rejet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showRejectModal(demandeId) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        const motifTextarea = document.getElementById('motif_rejet');

        let actionUrl = "{{ route('admin.demandes.updateStatus', ['demande' => ':id']) }}";
        form.action = actionUrl.replace(':id', demandeId);

        // Réinitialiser le champ motif et l'attribut required
        if(motifTextarea) {
            motifTextarea.value = '';
            motifTextarea.setAttribute('required', 'required'); // Rendre obligatoire quand le modal s'ouvre pour rejeter
        }
        
        if (modal) modal.style.display = 'flex';
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        const motifTextarea = document.getElementById('motif_rejet');
        if (modal) modal.style.display = 'none';
        if (motifTextarea) {
            motifTextarea.value = '';
            motifTextarea.removeAttribute('required'); // Optionnel: enlever required à la fermeture
        }
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('rejectModal');
        if (event.target == modal) {
            closeRejectModal();
        }
    });
</script>
@endpush