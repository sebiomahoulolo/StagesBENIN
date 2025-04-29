@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
    @section('content')


    <div class="container">
        <h1>{{ $catalogue->titre }}</h1>
        <p>{{ $catalogue->description }}</p>
        <!-- Ajoute d'autres champs ici selon ton modèle -->
    </div>

      @endsection
    @push('scripts')
        {{-- Scripts spécifiques si besoin --}}
    @endpush
