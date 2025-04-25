<div>
    <div class="container-fluid d-flex flex-column flex-md-grow-1">
        <!-- Titre et bouton nouvelle conversation -->
        <h1 class="h2 d-flex justify-content-between">
            Messagerie
            <button class="btn btn-primary" wire:click="toggleCreateConversation">
                <i class="fas fa-plus me-1"></i> Nouvelle conversation
            </button>
        </h1>
        
        <!-- Conteneur principal -->
        <div class="row flex-md-grow-1">
            <!-- Liste des conversations (colonne gauche) -->
            <div class="col-12 col-md-4 col-xxl-3 d-md-flex mw-lg-350px">
                @livewire('nouvelle-messagerie.conversation-list')
            </div>
            
            <!-- Zone principale (colonne droite) -->
            <div class="col d-flex min-h-500px">
                @if($showCreateConversation)
                    <!-- Formulaire de création de conversation -->
                    @livewire('nouvelle-messagerie.create-conversation')
                @elseif($selectedConversationId)
                    <!-- Affichage d'une conversation sélectionnée -->
                    <div class="card border-0 flex-grow-1">
                        @livewire('nouvelle-messagerie.conversation-messages', ['conversationId' => $selectedConversationId])
                        @livewire('nouvelle-messagerie.message-form', ['conversationId' => $selectedConversationId])
                    </div>
                @else
                    <!-- État initial ou aucune conversation sélectionnée -->
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

    <!-- Notifications -->
    @if(session()->has('error'))
        <script>
            document.addEventListener('livewire:load', function() {
                showToast("{{ session('error') }}", "danger");
            });
        </script>
    @endif
</div> 