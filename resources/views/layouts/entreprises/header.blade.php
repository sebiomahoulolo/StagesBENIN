<header>
    <div class="logo">
        <i class="fas fa-building"></i>
        <span>RecrutPro</span>
    </div>
    <div class="header-actions">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher...">
        </div>
        <div class="notifications">
            <i class="fas fa-bell"></i>
            <div class="badge">5</div>
        </div>
        <div class="messages">
            <i class="fas fa-envelope"></i>
            <div class="badge">3</div>
        </div>
        <div class="profile-menu">
            <div class="profile-image">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-role">Administrateur</div>
            </div>
        </div>
    </div>
</header>