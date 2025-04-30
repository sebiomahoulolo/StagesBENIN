{{-- /resources/views/etudiants/cv/show.blade.php --}}

@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

{{-- Inclut le CSS spécifique et ajoute la classe au body --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cv-show.css') }}">
@endpush
@push('body-class', 'cv-show-page') {{-- Ajoute la classe pour le style body spécifique --}}


@section('content')

    {{-- Messages Flash --}}
     @if(session('success'))
         <div class="flash-message flash-success">{{ session('success') }}</div>
     @endif
     @if(session('error'))
         <div class="flash-message flash-error">{{ session('error') }}</div>
     @endif

    {{-- Barre d'action --}}
    <div class="cv-action-bar">
        <h2>Visualisation de votre CV</h2>
        <div class="buttons">
            <a href="{{ route('etudiants.cv.edit', ['cvProfile' => $cvProfile->id]) }}" class="btn-edit">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="javascript:void(0);" class="btn-pdf" onclick="generatePdf()">
    <i class="fas fa-file-pdf"></i> Télécharger PDF
</a>

            <a href="{{ route('etudiants.cv.export.png', ['cvProfile' => $cvProfile->id]) }}" class="btn-png" target="_blank">
                <i class="fas fa-file-image"></i> Télécharger PNG
            </a>
        </div>
    </div>

    {{-- Conteneur de l'aperçu du CV --}}
    <div id="cv-content">
    <div class="cv-preview-wrapper">
        {{-- Inclusion du template CV --}}
        @include('etudiants.cv.templates.default', ['cvProfile' => $cvProfile])
    </div>
</div>
@endsection
<script>
    function generatePdf() {
        const element = document.getElementById('cv-content');
        const opt = {
            margin:       0.5,
            filename:     'CV_de_{{ $cvProfile->etudiant->nom ?? "Non_specifie" }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(element).set(opt).save();
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

@push('scripts')
{{-- Suppression du script html2pdf.js --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // Fonction generatePdf() supprimée
</script> --}}
@endpush