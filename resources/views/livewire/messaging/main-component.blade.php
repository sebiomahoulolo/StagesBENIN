<div>
    <!-- La sagesse commence par la connaissance de soi-même -->
    
    <div class="container-fluid d-flex flex-column flex-md-grow-1">
        <!-- Title -->
        <h1 class="h2 d-flex justify-content-between">
            Chat
            <button class="btn btn-primary" wire:click="toggleCreateConversation">
                <i class="fas fa-plus me-1"></i> Nouvelle conversation
            </button>
        </h1>
        <div class="row flex-md-grow-1">
            <div class="col-12 col-md-4 col-xxl-3 d-md-flex mw-lg-350px">
                <!-- Conversation List -->
                @livewire('messaging.conversation-list')
            </div>
            <div class="col d-flex min-h-500px">
                <!-- Zone principale -->
                @if($showCreateConversation)
                    @livewire('messaging.create-conversation')
                @elseif($selectedConversationId)
                    <div class="card border-0 flex-grow-1">
                        @livewire('messaging.conversation-messages', ['conversationId' => $selectedConversationId])
                        @livewire('messaging.message-form', ['conversationId' => $selectedConversationId])
                    </div>
                @else
                    <div class="card border-0 flex-grow-1">
                        <div class="card-body text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                                <h4>Aucune conversation sélectionnée</h4>
                                <p class="text-muted">Sélectionnez une conversation ou créez-en une nouvelle</p>
                                <button class="btn btn-primary mt-2" wire:click="toggleCreateConversation">
                                    <i class="fas fa-plus me-1"></i> Nouvelle conversation
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upload files Modal -->
    <div class="modal fade" id="uploadFilesModal" tabindex="-1" role="dialog" aria-labelledby="uploadFilesModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header pb-0">
                    <h3 id="uploadFilesModalTitle" class="modal-title">Ajouter des fichiers</h3>
                    <!-- Button -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- End Header -->
                <!-- Body -->
                <div class="modal-body">
                    <!-- Dropzone -->
                    <div class="dropzone text-center px-4 py-6" data-dropzone='{"autoProcessQueue": false}'>
                        <div class="dz-message">
                            <img class="avatar avatar-xxl mb-3" src="{{ asset('images/upload-illustration.svg') }}" alt="...">
                            <h5 class="mb-4">Glissez et déposez votre fichier ici</h5>
                            <p class="mb-4">ou</p>
                            <span class="btn btn-sm btn-gray-300">Parcourir les fichiers</span>
                        </div>
                    </div>
                    <!-- End Dropzone -->
                </div>
                <!-- End Body -->
                <!-- Footer -->
                <div class="modal-footer pt-0">
                    <!-- Button -->
                    <button type="button" class="btn btn-light" data-cancel-files data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                    <!-- Button -->
                    <button type="button" class="btn btn-primary" data-upload-files>Télécharger</button>
                </div>
                <!-- End Footer -->
            </div>
        </div>
    </div>
</div>
