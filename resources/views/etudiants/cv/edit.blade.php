{{-- /resources/views/etudiants/cv/edit.blade.php --}}

@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

{{-- Inclut le fichier CSS spécifique à l'éditeur --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cv-editor.css') }}">
@endpush

@section('content')
    {{-- ... (contenu de edit.blade.php comme fourni précédemment) ... --}}
     <div class="content-header">
         <div class="welcome-message">
             <h1>Éditeur de CV</h1>
             <p>Remplissez ou modifiez chaque section pour construire votre CV.</p>
         </div>
         <div class="quick-actions">
             @php $cvProfileId = Auth::user()->etudiant?->cvProfile?->id; @endphp
             @if($cvProfileId)
                 <a href="{{ route('etudiants.cv.show', ['cvProfile' => $cvProfileId]) }}" class="action-button" target="_blank">
                     <i class="fas fa-eye"></i> <span>Visualiser le CV</span>
                 </a>
             @endif
         </div>
     </div>

     @if (session()->has('warning'))
         <div class="alert alert-warning mb-4">
             {{ session('warning') }}
         </div>
     @endif

     @if (session()->has('message'))
         <div class="alert alert-success mb-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
             {{ session('message') }}
         </div>
     @endif
     @if (session()->has('error'))
         <div class="alert alert-danger mb-4">
             {{ session('error') }}
         </div>
     @endif

     <div class="cv-editor-container">
         @isset($cvProfile)
             @livewire('etudiants.cv-profile-form', ['cvProfileId' => $cvProfile->id], key('lw-profile-'.$cvProfile->id))
             @livewire('etudiants.cv-formations-form', ['cvProfileId' => $cvProfile->id], key('lw-formations-'.$cvProfile->id))
             @livewire('etudiants.cv-experiences-form', ['cvProfileId' => $cvProfile->id], key('lw-experiences-'.$cvProfile->id))
             @livewire('etudiants.cv-competences-form', ['cvProfileId' => $cvProfile->id], key('lw-competences-'.$cvProfile->id))
             @livewire('etudiants.cv-langues-form', ['cvProfileId' => $cvProfile->id], key('lw-langues-'.$cvProfile->id))
             @livewire('etudiants.cv-centres-interet-form', ['cvProfileId' => $cvProfile->id], key('lw-interets-'.$cvProfile->id))
             @livewire('etudiants.cv-certifications-form', ['cvProfileId' => $cvProfile->id], key('lw-certs-'.$cvProfile->id))
             @livewire('etudiants.cv-projets-form', ['cvProfileId' => $cvProfile->id], key('lw-projets-'.$cvProfile->id))
             @livewire('etudiants.cv-references-form', ['cvProfileId' => $cvProfile->id], key('lw-references-'.$cvProfile->id))
         @else
             <div class="alert alert-danger">
                 <strong>Erreur Critique :</strong> Le profil CV nécessaire pour l'édition n'a pas pu être chargé.
                 Veuillez vous assurer d'avoir créé un profil ou contacter le support technique.
             </div>
             @php \Log::critical("[CV Edit View] La variable \$cvProfile est manquante pour l'utilisateur ID: " . Auth::id()); @endphp
         @endisset
     </div>
@endsection

@push('scripts')
@endpush