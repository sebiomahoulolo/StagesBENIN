@extends('layouts.entreprises.master')
@section('content')
<div class="card mb-4">
    <h1 class="card-header text-center">Création d'Annonce</h1>
    <div class="card-body bg-gradient">
        @livewire('entreprise.annonce')
    </div>
</div>


@endsection
@push('script')
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector("#myTextarea"))
        .catch(error => {
            console.error(error);
        })

    ;
    CKEDITOR.config.height = 500; // 500 pixels high.
    // .tabsize: 2,
    // .height: 120,
</script>

@endpush