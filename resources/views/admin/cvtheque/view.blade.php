@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
{{-- /resources/views/etudiants/cv/show.blade.php --}}

    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="flash-message flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-message flash-error">{{ session('error') }}</div>
    @endif

    {{-- Barre d'action --}}
    <div class="cv-action-bar">
        <h2>Visualisation du CV de {{ $cvProfile->etudiant->nom ?? 'Non spécifié' }}.  <div class="buttons">
            <button onclick="generatePdf()" class="btn-pdf">
                <i class="fas fa-file-pdf"></i> Télécharger en PDF
            </button>
            
        </div></h2>
        
    </div>
    <style>
.btn-pdf {
    background-color: #007bff; /* Couleur bleu */
    color: white; /* Texte blanc */
    border: none; /* Supprime les bordures */
    padding: 10px 20px; /* Espacement interne */
    border-radius: 5px; /* Coins arrondis */
    font-size: 16px; /* Taille du texte */
    cursor: pointer; /* Curseur pointeur */
    display: inline-flex; /* Alignement de l'icône et du texte */
    align-items: center;
    gap: 8px; /* Espace entre l'icône et le texte */
}

/* Effet au survol */
.btn-pdf:hover {
    background-color: #0056b3; /* Bleu foncé au survol */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Ombre subtile */
}

/* Effet au clic */
.btn-pdf:active {
    background-color: #003d80; /* Encore plus foncé au clic */
    transform: scale(0.98); /* Légère réduction de taille */
}

</style>
    {{-- Conteneur de l'aperçu du CV --}}
    <div id="cv-content" class="cv-preview-wrapper">
        {{-- Inclusion du template CV --}}
        @include('etudiants.cv.templates.default', ['cvProfile' => $cvProfile])
    </div>

@endsection

@push('scripts')
    {{-- Réactivation de html2pdf.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function generatePdf() {
            const element = document.getElementById('cv-content');
            const opt = {
                margin:       0.5,
                filename:     'CV_de_{{ $cvProfile->etudiant->nom ?? 'Non spécifié' }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(opt).save();
        }
    </script>
@endpush
