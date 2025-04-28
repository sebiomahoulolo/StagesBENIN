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
                        <option value="{{ $user->id }}" data-avatar="{{ $user->etudiant?->photo_path ? Storage::url($user->etudiant->photo_path) : '' }}">
                            {{ $user->name }}
                        </option>
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

@push('styles')
<style>
    /* Style pour les options de Select2 */
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        padding: 5px;
    }
    
    /* Style pour les éléments sélectionnés */
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 2px 10px;
        margin: 2px;
    }
    
    /* Style pour l'avatar dans les éléments sélectionnés */
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice .user-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 5px;
        object-fit: cover;
    }
    
    /* Style pour l'avatar dans le dropdown */
    .select2-container--bootstrap-5 .select2-results__option .user-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }
    
    /* Style pour le placeholder */
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__placeholder {
        color: #6c757d;
        margin-left: 5px;
    }
    
    /* Style pour le bouton de suppression */
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove {
        margin-left: 5px;
        color: #6c757d;
        cursor: pointer;
    }
    
    /* Style pour le dropdown */
    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Style pour les options dans le dropdown */
    .select2-container--bootstrap-5 .select2-results__option {
        display: flex;
        align-items: center;
        padding: 8px 12px;
    }
    
    /* Style pour l'option sélectionnée */
    .select2-container--bootstrap-5 .select2-results__option--selected {
        background-color: #e9ecef;
    }
    
    /* Style pour l'option au survol */
    .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        // Initialiser Select2 pour une meilleure sélection des utilisateurs
        $(document).ready(function() {
            $('.select2-users').select2({
                placeholder: 'Sélectionnez des participants',
                allowClear: true,
                theme: 'bootstrap-5',
                templateResult: formatUserOption,
                templateSelection: formatUserSelection
            });

            // Synchroniser les sélections avec Livewire
            $('.select2-users').on('change', function() {
                @this.set('selectedUsers', $(this).val());
            });
        });
        
        // Fonction pour formater les options dans le dropdown
        function formatUserOption(user) {
            if (!user.id) return user.text; // Pour le placeholder
            
            const avatarUrl = $(user.element).data('avatar');
            const userName = user.text;
            
            if (avatarUrl) {
                return $(`
                    <div class="d-flex align-items-center">
                        <img src="${avatarUrl}" class="user-avatar" alt="${userName}">
                        <span>${userName}</span>
                    </div>
                `);
            } else {
                return $(`
                    <div class="d-flex align-items-center">
                        <div class="user-avatar bg-secondary d-flex align-items-center justify-content-center text-white">
                            ${userName.charAt(0)}
                        </div>
                        <span>${userName}</span>
                    </div>
                `);
            }
        }
        
        // Fonction pour formater les éléments sélectionnés
        function formatUserSelection(user) {
            if (!user.id) return user.text; // Pour le placeholder
            
            const avatarUrl = $(user.element).data('avatar');
            const userName = user.text;
            
            if (avatarUrl) {
                return $(`
                    <div class="d-flex align-items-center">
                        <img src="${avatarUrl}" class="user-avatar" alt="${userName}">
                        <span>${userName}</span>
                    </div>
                `);
            } else {
                return $(`
                    <div class="d-flex align-items-center">
                        <div class="user-avatar bg-secondary d-flex align-items-center justify-content-center text-white">
                            ${userName.charAt(0)}
                        </div>
                        <span>${userName}</span>
                    </div>
                `);
            }
        }
    });
</script>
@endpush 