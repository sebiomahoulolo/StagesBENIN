<div>
    @if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="" class="form" wire:submit.prevent="storeAnnonce()">
        <input wire:model="entreprise_id" class="form-control" type="hidden" value="{{ Auth::user()->id }}" id="" />
        <label for="html5-text-input" class="col-md-2 col-form-label">Nom du poste <b style="color: red;">*</b> </label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <input wire:model="nom_du_poste" class="form-control" type="text" value="" id="html5-text-input" />
            </div>
            @error('nom_du_poste')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for=" html5-search-input" class="col-md-2 col-form-label">Type de poste <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <select wire:model="type_de_poste" name="" id="" class="form-select">
                    <option value="Stage">Stage</option>
                    <option value="Emploi">Emploi</option>
                </select>
            </div>
            @error('type_de_poste')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for="html5-email-input" class="col-md-2 col-form-label">Nombre de Place <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <input wire:model="nombre_de_place" class="form-control" type="number" id="html5-email-input" />
            </div>
            @error('nombre_de_place')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for="html5-url-input" class="col-md-2 col-form-label">Niveau d'étude <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <select wire:model="niveau_detude" name="" id="" class="form-select">
                    <option value="BEPC">BEPC</option>
                    <option value="CAP">CAP</option>
                    <option value="BAC">BAC</option>
                    <option value="BAC+1">BAC+1</option>
                    <option value="BAC+2">BAC+2</option>
                    <option value="BAC+3">BAC+3</option>
                    <option value="BAC+4">BAC+4</option>
                    <option value="BAC+5">BAC+5</option>
                    <option value="Doctorat">Doctorat</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            @error('niveau_detude')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for="html5-tel-input" class="col-md-6 col-form-label">Domaine d'Etude ou de Formation <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <input wire:model="domaine" class="form-control" type="text" value="" id="html5-tel-input" />
            </div>
            @error('domaine')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for="html5-password-input" class="col-md-2 col-form-label">Lieu du Poste <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <input wire:model="lieu" class="form-control" type="text" value="" id="html5-password-input" />
            </div>
            @error('lieu')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for="html5-number-input" class="col-md-2 col-form-label">Email <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <input wire:model="email" class="form-control" type="email" value="" id="html5-number-input" />
            </div>
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Date de cloture <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <input wire:model="date_cloture"
                    class="form-control"
                    type="datetime-local"
                    value="2021-06-18T12:30:00"
                    id="html5-datetime-local-input" />
            </div>
            @error('date_cloture')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for="html5-date-input" class="col-md-6 col-form-label">Description du Poste <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <textarea wire:model="description" value="" id="myTextarea" class="form-control"></textarea>
            </div>
            @error('description')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <input type="submit" value="Publier" class="btn btn-info">
    </form>

</div>