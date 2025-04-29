<div>
    @if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session()->has('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif
    <div class="" id="">
        <div class="lg">
            <div class="content">
                <form wire:submit.prevent="storeEvent()" action="" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="event_title" class="form-label">Titre de l'événement*</label>
                            <input wire:model="title" type="text" class="form-control" id="event_title" name="title" required>
                            <div class="invalid-feedback">Veuillez saisir un titre.</div>
                        </div>
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="mb-3">
                            <label for="event_description" class="form-label">Description</label>
                            <textarea wire:model="description" class="form-control" id="event_description" name="description" rows="3"></textarea>
                        </div>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="event_start_date" class="form-label">Date et heure de début*</label>
                                <input wire:model="start_date" type="datetime-local" class="form-control" id="event_start_date" name="start_date" required>
                                <div class="invalid-feedback">Veuillez saisir une date de début valide.</div>
                                @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="event_end_date" class="form-label">Date et heure de fin*</label>
                                <input wire:model="end_date" type="datetime-local" class="form-control" id="event_end_date" name="end_date" required>
                                <div class="invalid-feedback">La date de fin doit être postérieure à la date de début.</div>
                                @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="event_location" class="form-label">Lieu</label>
                            <input wire:model="location" type="text" class="form-control" id="event_location" name="location">
                        </div>
                        @error('location')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="event_type" class="form-label">Type d'événement</label>
                                <select wire:model="type" class="form-select" id="event_type" name="type">
                                    <option value="">Sélectionner un type</option>
                                    <option value="Conférence">Conférence</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Salon">Salon</option>
                                    <option value="Formation">Formation</option>
                                    <option value="Networking">Networking</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                @error('type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="event_max_participants" class="form-label">Nombre max. de participants</label>
                                <input wire:model="max_participants" type="number" class="form-control" id="event_max_participants" name="max_participants" min="1">
                                @error('max_participants')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="event_image" class="form-label">Image (affiche)</label>
                            <input wire:model="image" type="file" class="form-control" id="event_image" name="image" accept="image/*">
                        </div>
                        @error('image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="footer">
                        <button type="reset" class="btn btn-secondary mr-3">Annuler</button>
                        <button type="submit" class="btn btn-primary submit-btn ml-2" id="submitEvent">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>