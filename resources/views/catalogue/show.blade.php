@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $catalogue->titre }}</h1>
        <p>{{ $catalogue->description }}</p>
        <!-- Ajoute d'autres champs ici selon ton modèle -->
    </div>
@endsection
