@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Modifier le post</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('messagerie-sociale.update-post', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Contenu</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                    id="content"
                                    name="content"
                                    rows="5"
                                    required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($post->attachments->isNotEmpty())
                            <div class="mb-3">
                                <label class="form-label">Fichiers joints actuels</label>
                                <div class="list-group">
                                    @foreach($post->attachments as $attachment)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $attachment->original_name }}</span>
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="deleteAttachment({{ $attachment->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="attachments" class="form-label">Ajouter des fichiers</label>
                            <input type="file"
                                   class="form-control @error('attachments.*') is-invalid @enderror"
                                   id="attachments"
                                   name="attachments[]"
                                   multiple>
                            <small class="form-text text-muted">
                                Vous pouvez sélectionner plusieurs fichiers. Taille maximale par fichier : 10MB
                            </small>
                            @error('attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('messagerie-sociale.show-post', $post) }}"
                               class="btn btn-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteAttachment(attachmentId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce fichier ?')) {
        fetch(`/canal-messagerie/attachments/${attachmentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Une erreur est survenue lors de la suppression du fichier.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la suppression du fichier.');
        });
    }
}
</script>
@endpush
@endsection
