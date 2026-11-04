<aside class="d-sidebar">
    <div class="brand">
        <div class="brand-logo">
            <svg viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff" d="M14.747 9.125c.527-1.426 1.736-2.573 3.317-2.573c1.643 0 2.792 1.085 3.318 2.573l6.077 16.867c.186.496.248.931.248 1.147c0 1.209-.992 2.046-2.139 2.046c-1.303 0-1.954-.682-2.264-1.611l-.931-2.915h-8.62l-.93 2.884c-.31.961-.961 1.642-2.232 1.642c-1.24 0-2.294-.93-2.294-2.17c0-.496.155-.868.217-1.023l6.233-16.867zm.34 11.256h5.891l-2.883-8.992h-.062l-2.946 8.992z"/>
            </svg>
        </div>
        <div class="brand-text">
            <div class="brand-name">Adminator</div>
            <div class="brand-tag">v4.1.2 · preview</div>
        </div>
    </div>

    <!-- Menú de navegación principal -->
    <nav class="sidebar-nav">
        <div class="nav-section">WORKSPACE</div>

        <a href="{{ route('home.index')}}" class="nav-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="#" class="nav-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            <span>Go Pro</span>
            <span class="badge badge--pro">PRO</span>
        </a>

        <div class="nav-section">APARTADOS</div>

        <a href="{{ route('usuarios.index')}}" class="nav-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="20" height="16" x="2" y="4" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
            <span>Usuarios</span>
        </a>

        <a href="#" class="nav-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
            </svg>
            <span>Compose</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="workspace">
            <div class="workspace-avatar">JD</div>
            <div class="workspace-text">
                <div class="workspace-name">John Doe</div>
                <div class="workspace-role">admin</div>
            </div>
            <svg class="workspace-chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="m7 9 5-5 5 5"/><path d="m7 15 5 5 5-5"/>
            </svg>
        </div>
    </div>
</aside>