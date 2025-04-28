<div class="card">
    <div class="card-header">
        <h4>Créer un nouveau post</h4>
    </div>
    <div class="card-body">
        @if(session('submit_error'))
            <div class="alert alert-danger">
                {{ session('submit_error') }}
            </div>
        @endif
        
        <form wire:submit.prevent="submitPost">
            <div class="mb-3">
                <label for="content" class="form-label">Contenu</label>
                <textarea 
                    id="content" 
                    class="form-control @error('content') is-invalid @enderror" 
                    wire:model.lazy="content" 
                    rows="5" 
                    placeholder="Rédigez votre message ici..."
                    @if($isSubmitting) disabled @endif
                ></textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="attachments" class="form-label d-block">Pièces jointes</label>
                <input 
                    type="file" 
                    id="attachments" 
                    class="form-control @error('attachments.*') is-invalid @enderror" 
                    wire:model="attachments" 
                    multiple 
                    @if($isSubmitting) disabled @endif
                >
                <small class="text-muted">Taille maximale: 10MB par fichier</small>
                @error('attachments.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if(count($attachments) > 0)
                    <div class="mt-3">
                        <h6>Pièces jointes sélectionnées:</h6>
                        <div class="row g-2">
                            @foreach($attachments as $index => $attachment)
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="position-relative attachment-preview">
                                        @if(in_array($attachment->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ $attachment->temporaryUrl() }}" class="img-thumbnail" alt="Aperçu">
                                        @else
                                            <div class="file-icon p-3 text-center bg-light border rounded">
                                                <i class="fas fa-file fa-2x text-secondary"></i>
                                                <p class="small text-truncate mt-2 mb-0">{{ $attachment->getClientOriginalName() }}</p>
                                            </div>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                                wire:click="removeAttachment({{ $index }})" 
                                                @if($isSubmitting) disabled @endif>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('messagerie-sociale.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary" @if($isSubmitting) disabled @endif>
                    @if($isSubmitting)
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Publication en cours...
                    @else
                        Publier
                    @endif
                </button>
            </div>
        </form>
    </div>
</div>