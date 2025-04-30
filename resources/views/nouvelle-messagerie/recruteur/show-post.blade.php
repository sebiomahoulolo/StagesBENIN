@extends('layouts.recruteur.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Détails de l'annonce</h1>
                <a href="{{ route('messagerie-sociale.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour au canal
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    @if(session('share_url'))
                        <div class="mt-2">
                            <p class="mb-1">Lien de partage:</p>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ session('share_url') }}" id="sessionShareUrl" readonly>
                                <button class="btn btn-outline-primary" type="button" onclick="copyShareUrl('sessionShareUrl')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(isset($share))
                <div class="alert alert-info mb-4">
                    <h5 class="alert-heading">Annonce partagée par {{ $share->user->name }}</h5>
                    @if($share->comment)
                        <p>{{ $share->comment }}</p>
                    @endif
                    <hr>
                    <p class="mb-0">Partagé le {{ $share->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            @endif
            
            @livewire('nouvelle-messagerie.post-card', ['post' => $post])
        </div>
    </div>
</div>

<script>
    function copyShareUrl(elementId) {
        const shareUrlInput = document.getElementById(elementId);
        shareUrlInput.select();
        document.execCommand('copy');
        
        // Optional: Show a copy confirmation
        const button = shareUrlInput.nextElementSibling;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    }
</script>
@endsection
