<header class="d-topbar">
    <!-- Migas de pan y botón hamburguesa -->
    <div class="crumbs">
        <button class="hamburger" data-drawer-open aria-label="Open navigation">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
        <span class="crumb-sec">Workspace</span>
        <span class="crumb-sep">/</span>
        <span class="crumb-cur">Dashboard</span>
    </div>

    <!-- Acciones de la barra superior -->
    <div class="topbar-actions">
        <!-- Buscador -->
        <button class="cmd" data-palette-open>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <span>Search...</span>
            <kbd class="kbd">⌘K</kbd>
        </button>

        <!-- Dropdown Notificaciones -->
        <div class="dd-wrap">
            <button class="icon-btn" data-dropdown aria-label="Notifications">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="count danger">3</span>
            </button>
        </div>

        <!-- Dropdown Mensajes -->
        <div class="dd-wrap">
            <button class="icon-btn" data-dropdown aria-label="Messages">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                <span class="count info">3</span>
            </button>
        </div>

        <!-- Botón de Tema (Dark / Light) -->
        <button class="icon-btn" id="themeToggle" aria-label="Toggle theme">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
        </button>

        <!-- Perfil de usuario -->
        <div class="dd-wrap">
            <div class="avatar" data-dropdown tabindex="0" role="button" aria-label="Account menu">JD</div>
            <div class="dd-menu dd-profile" role="menu">
                <div class="dd-profile-head">
                    <div class="dd-profile-name">John Doe</div>
                    <div class="dd-profile-email">john@adminator.app</div>
                </div>
                <a class="dd-menu-item" href="#">Settings</a>
                <a class="dd-menu-item" href="#">Profile</a>
                <a class="dd-menu-item" href="#">Messages</a>
                <div class="dd-divider"></div>
                <a class="dd-menu-item danger" href="#">Logout</a>
            </div>
        </div>
    </div>
</header>