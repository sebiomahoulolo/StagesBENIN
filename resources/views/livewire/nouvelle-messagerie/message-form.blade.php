<div class="card-footer bg-white p-3">
    @if($conversationId)
        <form wire:submit.prevent="sendMessage" enctype="multipart/form-data">
            <div class="d-flex align-items-end">
                <!-- Zone de saisie du message -->
                <div class="flex-grow-1 me-3">
                    <div class="form-floating">
                        <textarea class="form-control" 
                                  id="messageText" 
                                  placeholder="Écrivez votre message ici..."
                                  style="height: 80px; resize: none;"
                                  wire:model.defer="messageText"
                                  @if($uploading) disabled @endif></textarea>
                        <label for="messageText">Message</label>
                    </div>
                    
                    <!-- Affichage des erreurs -->
                    @error('messageText')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    
                    <!-- Preview des pièces jointes -->
                    @if(count($attachments) > 0)
                        <div class="attachments-preview mt-2 d-flex flex-wrap">
                            @foreach($attachments as $index => $attachment)
                                <div class="attachment-item me-2 mb-2 position-relative">
                                    @if(in_array($attachment->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ $attachment->temporaryUrl() }}" alt="Preview" class="img-thumbnail" width="80">
                                    @else
                                        <div class="file-preview d-flex align-items-center justify-content-center bg-light border rounded p-2" style="width: 80px; height: 80px;">
                                            <i class="fas fa-file fa-2x text-secondary"></i>
                                        </div>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" wire:click="removeAttachment({{ $index }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Boutons d'action -->
                <div class="d-flex align-items-center">
                    <!-- Bouton d'attachement -->
                    <label for="attachments" class="btn btn-light mx-1" title="Ajouter des fichiers">
                        <i class="fas fa-paperclip"></i>
                        <input type="file" id="attachments" class="d-none" wire:model="attachments" multiple>
                    </label>
                    
                    <!-- Bouton emoji (optionnel) -->
                    <button type="button" class="btn btn-light mx-1" title="Ajouter un emoji">
                        <i class="fas fa-smile"></i>
                    </button>
                    
                    <!-- Bouton d'envoi -->
                    <button type="submit" class="btn btn-primary ms-2" @if($uploading) disabled @endif>
                        @if($uploading)
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        @else
                            <i class="fas fa-paper-plane"></i>
                        @endif
                    </button>
                </div>
            </div>
            
            <!-- Indicateur de progression (visible uniquement pendant l'upload) -->
            @if($uploading)
                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                </div>
            @endif
        </form>
    @endif
</div> 