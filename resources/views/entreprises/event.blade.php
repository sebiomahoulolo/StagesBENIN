@extends('layouts.entreprises.master')
@section('content')
<div class="card mb-4">
    <h1 class="card-header text-center">Création d'un évènement</h1>
    <div class="card-body bg-gradient">
        @livewire('entreprise.event')
    </div>
</div>


@endsection
@push('script')

@endpush