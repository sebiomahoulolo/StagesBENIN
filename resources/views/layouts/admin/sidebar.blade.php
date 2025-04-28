<!-- Plaintes & Suggestions -->
<li class="nav-item">
    <a class="nav-link {{ Route::is('admin.complaints.*') ? 'active' : '' }}" href="{{ route('admin.complaints.index') }}">
        <i class="fas fa-comment-dots me-2"></i>
        <span>Plaintes & Suggestions</span>
    </a>
</li> 