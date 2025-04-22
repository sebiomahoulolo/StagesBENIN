<div class="card-footer bg-white shadow-sm position-relative" style="opacity: 1; z-index: 10;">
    @if($conversationId)
        <form wire:submit.prevent="sendMessage" class="position-relative">
            <div class="row gx-3">
                <div class="col">
                    <div class="input-group input-group-merge">
                        <!-- Button -->
                        <a href="javascript:void(0);" class="input-group-text pe-1 bg-light border-light link-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="18" width="18">
                                <g>
                                    <path d="M12,0A12,12,0,1,0,24,12,12,12,0,0,0,12,0Zm0,22A10,10,0,1,1,22,12,10,10,0,0,1,12,22Z" style="fill: currentColor"/>
                                    <path d="M16.49,14.13a1,1,0,0,0-1.36.38,3.68,3.68,0,0,1-3.13,2,3.68,3.68,0,0,1-3.13-2,1,1,0,1,0-1.74,1,5.62,5.62,0,0,0,4.87,3,5.62,5.62,0,0,0,4.87-3A1,1,0,0,0,16.49,14.13Z" style="fill: currentColor"/>
                                    <circle cx="8" cy="9" r="2" style="fill: currentColor"/>
                                    <circle cx="16" cy="9" r="2" style="fill: currentColor"/>
                                </g>
                            </svg>
                        </a>
                        <!-- Input -->
                        <input type="text" class="form-control form-control-lg bg-light border-light" 
                            id="message" placeholder="Tapez un message..." 
                            wire:model.defer="message" 
                            @if($isSending) disabled @endif
                            autocomplete="off">
                    </div>
                    @error('message')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-auto">
                    <!-- Button -->
                    <div
                        x-data="{ 
                            isUploading: false, 
                            progress: 0,
                            isHovering: false
                        }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                        <label class="d-flex align-items-center justify-content-center btn btn-light link-secondary rounded-circle w-50px h-50px p-0" 
                            title="Ajouter une pièce jointe"
                            x-bind:class="{ 'bg-primary text-white': isHovering }"
                            x-on:mouseenter="isHovering = true"
                            x-on:mouseleave="isHovering = false"
                            @if($isSending) disabled @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="18" width="18">
                                <path d="M21.84,3.46a7,7,0,0,0-9.84,0L1.62,13.83a5.13,5.13,0,0,0,7.25,7.25l8.43-8.43A3.29,3.29,0,1,0,12.65,8L7.46,13.18a1,1,0,0,0,0,1.42,1,1,0,0,0,1.41,0l5.19-5.19a1.3,1.3,0,0,1,2.21.91,1.32,1.32,0,0,1-.38.92L7.46,19.67a3.13,3.13,0,0,1-5.34-2.21A3.09,3.09,0,0,1,3,15.25L13.41,4.87a5,5,0,0,1,7,7l-7.78,7.78a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l7.78-7.78a7,7,0,0,0,0-9.84Z" style="fill: currentColor"/>
                            </svg>
                            <input type="file" class="d-none" wire:model="attachments" multiple @if($isSending) disabled @endif>
                        </label>
                        <!-- Upload Progress -->
                        <div x-show="isUploading" class="mt-2">
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar" role="progressbar" x-bind:style="`width: ${progress}%`"></div>
                            </div>
                        </div>
                    </div>
                    @error('attachments.*')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-auto">
                    <!-- Dropdown pour options supplémentaires -->
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle no-arrow d-flex align-items-center justify-content-center btn btn-light link-secondary rounded-circle w-50px h-50px p-0" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="18" width="18">
                                <g>
                                    <circle cx="3.25" cy="12" r="3.25" style="fill: currentColor"/>
                                    <circle cx="12" cy="12" r="3.25" style="fill: currentColor"/>
                                    <circle cx="20.75" cy="12" r="3.25" style="fill: currentColor"/>
                                </g>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item">Archiver la conversation</a>
                            <a href="javascript:void(0);" class="dropdown-item">Supprimer l'historique</a>
                            <a href="javascript:void(0);" class="dropdown-item">Bloquer le contact</a>
                        </div>
                    </div>
                </div>
                <div class="w-100 d-block d-md-none"></div>
                <div class="col col-md-auto ps-lg-7 mt-2 mt-md-0">
                    <!-- Button -->
                    <button type="submit" class="btn btn-lg btn-primary w-100 position-relative" style="z-index: 15;" @if($isSending) disabled @endif>
                        <span wire:loading.class="d-inline-block" wire:loading.class.remove="d-none" wire:target="sendMessage" class="spinner-border spinner-border-sm me-2 d-none" role="status">
                            <span class="visually-hidden">Envoi en cours...</span>
                        </span>
                        <svg viewBox="0 0 24 24" height="18" width="18" class="me-1" xmlns="http://www.w3.org/2000/svg" wire:loading.remove wire:target="sendMessage">
                            <path d="M2.759,15.629a1.664,1.664,0,0,1-.882-3.075L20.36,1A1.663,1.663,0,0,1,22.876,2.72l-3.6,19.173a1.664,1.664,0,0,1-2.966.691L11.1,15.629Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                            <path d="M11.1,15.629H8.6V20.8a1.663,1.663,0,0,0,2.6,1.374l3.178-2.166Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                            <path d="M11.099 15.629L22.179 1.039" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                        </svg>
                        <span wire:loading.remove wire:target="sendMessage">Envoyer</span>
                        <span wire:loading wire:target="sendMessage">Envoi...</span>
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-info mb-0">
            Sélectionnez une conversation pour envoyer un message.
        </div>
    @endif
</div>
