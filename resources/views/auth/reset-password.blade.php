<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
        <h2 class="text-center text-primary mb-4">
            StagesBENIN - Nouveau mot de passe
        </h2>

        <!-- Si tu veux un petit texte explicatif -->
        <p class="text-center text-muted mb-4">
            {{ __('Veuillez saisir votre nouveau mot de passe ci-dessous.') }}
        </p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Jeton de réinitialisation -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Adresse Email -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="form-control">
                <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
            </div>

            <!-- Nouveau mot de passe -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Nouveau mot de passe') }}</label>
                <input type="password" id="password" name="password" required autocomplete="new-password" class="form-control">
                <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
            </div>

            <!-- Confirmation mot de passe -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="form-control">
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    {{ __('Réinitialiser le mot de passe') }}
                </button>
            </div>
        </form>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
