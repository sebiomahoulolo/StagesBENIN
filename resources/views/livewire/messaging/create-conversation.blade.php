<div class="card border-0 flex-grow-1">
    <div class="card-header border-0">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="javascript:void(0);" class="btn btn-link text-dark me-2" wire:click="$emit('closeCreateConversation')">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="card-header-title h3">Nouvelle conversation</h2>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <form wire:submit.prevent="createConversation">
            <div class="mb-4">
                <label for="participants" class="form-label fw-bold">Participants</label>
                <select class="form-select select2-users" id="participants" wire:model="selectedUsers" multiple>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <div class="form-text">Sélectionnez un ou plusieurs participants pour votre conversation.</div>
                @error('selectedUsers') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-4" x-data="{ showGroupName: @entangle('showGroupNameField') }">
                <label for="group_name" class="form-label fw-bold">Nom du groupe <span x-show="showGroupName" class="text-danger">*</span></label>
                <input type="text" class="form-control" id="group_name" wire:model="groupName" placeholder="Laisser vide pour une conversation privée">
                <div class="form-text" x-show="showGroupName">Un nom de groupe est obligatoire pour les conversations avec plus de 2 participants.</div>
                @error('groupName') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-4">
                <label for="first_message" class="form-label fw-bold">Premier message <span class="text-danger">*</span></label>
                <textarea class="form-control" id="first_message" wire:model="firstMessage" rows="3" placeholder="Écrivez votre premier message..."></textarea>
                @error('firstMessage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-light me-2" wire:click="$emit('closeCreateConversation')">
                    Annuler
                </button>
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" height="18" width="18" class="me-1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.759,15.629a1.664,1.664,0,0,1-.882-3.075L20.36,1A1.663,1.663,0,0,1,22.876,2.72l-3.6,19.173a1.664,1.664,0,0,1-2.966.691L11.1,15.629Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                        <path d="M11.1,15.629H8.6V20.8a1.663,1.663,0,0,0,2.6,1.374l3.178-2.166Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                        <path d="M11.099 15.629L22.179 1.039" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                    </svg>
                    Créer la conversation
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        // Initialiser Select2 pour une meilleure sélection des utilisateurs
        $(document).ready(function() {
            $('.select2-users').select2({
                placeholder: 'Sélectionnez des participants',
                allowClear: true,
                theme: 'bootstrap-5'
            });

            // Synchroniser les sélections avec Livewire
            $('.select2-users').on('change', function() {
                @this.set('selectedUsers', $(this).val());
            });
        });
    });
</script>
@endpush 