<div>
    @if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form wire:submit.prevent="storeMessage()" action="" class="form">
        <input wire:model="entreprise_id" class="form-control" type="hidden" value="{{ Auth::user()->id }}" id="" />
        <label for="html5-text-input" class="col-md-2 col-form-label">Objet<b style="color: red;">*</b> </label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <input wire:model="objet" class="form-control" type="text" value="" id="html5-text-input" />
            </div>
            @error('objet')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label for="html5-date-input" class="col-md-6 col-form-label">Message <b style="color: red;">*</b></label>
        <div class="mb-3 row">
            <div class="col-md-10">
                <textarea wire:model="message" value="" id="myTextarea" class="form-control"></textarea>
            </div>
            @error('message')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <input type="submit" value="Publier" class="btn btn-info">
    </form>
</div>