{{-- Element du menu: Entreprise --}}
<li class="nav-item">
    <a class="nav-link {{ Route::is('entreprise.*') ? 'active' : '' }}" href="{{ route('entreprise.index') }}">
        <i class="fas fa-building me-2"></i>
        <span>Entreprise</span>
    </a>
</li>

{{-- Element du menu: Messagerie sociale --}}
<li class="nav-item">
    <a class="nav-link {{ Route::is('messagerie-sociale.*') ? 'active' : '' }}" href="{{ route('messagerie-sociale.index') }}">
        <i class="fas fa-bullhorn me-2"></i>
        <span>Canal d'annonces</span>
    </a>
</li>

{{-- Element du menu: Paramètres --}}
<li class="nav-item">
    <a class="nav-link {{ Route::is('parametres.*') ? 'active' : '' }}" href="{{ route('parametres.index') }}">
        <i class="fas fa-cogs me-2"></i>
        <span>Paramètres</span>
    </a>
</li>