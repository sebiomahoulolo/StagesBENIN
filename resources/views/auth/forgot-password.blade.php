<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
        <h2 class="text-center text-primary mb-4">
            StagesBENIN - Réinitialisation du mot de passe
        </h2>

        <p class="text-center text-muted mb-4">
            {{ __('Mot de passe oublié ? Pas de problème. Indiquez simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation qui vous permettra d’en choisir un nouveau.') }}
        </p>

        <!-- Session Status -->
        <div class="mb-3">
            <x-auth-session-status :status="session('status')" />
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
                <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    {{ __('Envoyer le lien de réinitialisation') }}
                </button>
            </div>
        </form>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
