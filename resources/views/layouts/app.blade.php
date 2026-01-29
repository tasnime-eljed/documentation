<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DevDocs - Documentation Professionnelle')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- AJOUT IMPORTANT : Bootstrap 5 (Pour que tes formulaires et tableaux s'affichent bien) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* --- TON CSS PERSONNALISÉ --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary-dark: #5D4E37;
            --primary: #8B7355;
            --primary-light: #A0826D;
            --secondary: #D4A574;
            --accent: #B8956A;
            --background: #FAF8F5;
            --white: #FFFFFF;
            --text-dark: #2D3748;
            --text-light: #718096;
            --shadow: rgba(93, 78, 55, 0.1);
            --sidebar-width: 280px;
            --navbar-height: 75px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--background);
            overflow-x: hidden;
        }

        /* Sidebar Marron Élégante */
        .app-sidebar {
            position: fixed; left: 0; top: 0; width: var(--sidebar-width); height: 100vh;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 50%, var(--accent) 100%);
            z-index: 1000; box-shadow: 4px 0 30px var(--shadow);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); overflow-y: auto;
        }
        .app-sidebar::-webkit-scrollbar { width: 6px; }
        .app-sidebar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); }
        .app-sidebar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 3px; }

        .sidebar-header {
            padding: 30px 24px; text-align: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px);
        }
        .sidebar-logo {
            display: flex; align-items: center; justify-content: center; gap: 14px;
            text-decoration: none; color: white; font-size: 24px; font-weight: 800; transition: all 0.3s ease;
        }
        .sidebar-logo:hover { transform: scale(1.05); }
        .sidebar-logo-icon { font-size: 36px; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-8px); } }

        .sidebar-section { padding: 24px 0; }
        .sidebar-section-title {
            padding: 0 24px; font-size: 11px; font-weight: 800; text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6); letter-spacing: 1px; margin-bottom: 12px;
        }

        .sidebar-menu { list-style: none; padding-left: 0; }
        .sidebar-menu li { margin-bottom: 6px; animation: slideInLeft 0.4s ease both; }
        .sidebar-menu li:nth-child(1) { animation-delay: 0.1s; }
        /* ... animations ... */

        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }

        .sidebar-menu a {
            display: flex; align-items: center; gap: 14px; padding: 14px 24px;
            color: rgba(255, 255, 255, 0.85); text-decoration: none; font-size: 15px; font-weight: 600;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative;
            margin: 0 12px; border-radius: 10px;
        }
        .sidebar-menu a::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
            background: var(--secondary); border-radius: 0 4px 4px 0; transform: scaleY(0); transition: transform 0.3s ease;
        }
        .sidebar-menu a:hover { background: rgba(255, 255, 255, 0.15); color: white; transform: translateX(5px); }
        .sidebar-menu a.active { background: rgba(255, 255, 255, 0.25); color: white; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
        .sidebar-menu a.active::before { transform: scaleY(1); }
        .sidebar-menu-icon { width: 22px; height: 22px; flex-shrink: 0; }

        /* Navbar */
        .app-navbar {
            position: fixed; top: 0; left: var(--sidebar-width); right: 0; height: var(--navbar-height);
            background: white; box-shadow: 0 2px 20px var(--shadow); display: flex; align-items: center;
            justify-content: space-between; padding: 0 32px; z-index: 999; backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(139, 115, 85, 0.1);
        }
        .navbar-title {
            font-size: 26px; font-weight: 800; background: linear-gradient(135deg, var(--primary-dark), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .navbar-actions { display: flex; align-items: center; gap: 20px; }
        .user-info {
            display: flex; align-items: center; gap: 14px; padding: 10px 18px;
            background: var(--background); border-radius: 12px; transition: all 0.3s ease;
        }
        .user-info:hover { background: #F0EBE3; transform: translateY(-2px); }
        .user-avatar {
            width: 42px; height: 42px; border-radius: 10px; background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 16px;
            box-shadow: 0 4px 12px rgba(139, 115, 85, 0.3);
        }
        .user-name { font-weight: 700; color: var(--text-dark); font-size: 15px; }
        .user-role { font-size: 12px; color: var(--text-light); font-weight: 600; }

        .btn-logout {
            padding: 12px 24px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white;
            border: none; border-radius: 10px; font-weight: 700; font-size: 14px; cursor: pointer;
            transition: all 0.3s; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(139, 115, 85, 0.3);
            position: relative; overflow: hidden;
        }
        .btn-logout:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(139, 115, 85, 0.4); }

        /* Contenu */
        .app-content {
            margin-left: var(--sidebar-width); margin-top: var(--navbar-height); padding: 32px;
            min-height: calc(100vh - var(--navbar-height)); animation: fadeIn 0.6s ease;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* Alerts */
        .alert-success {
            padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; background: #C6F6D5; color: #22543D;
            border-left: 4px solid var(--accent); display: flex; align-items: center; gap: 12px; font-weight: 600; animation: slideDown 0.4s ease;
        }
        .alert-error {
            padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; background: #FED7D7; color: #742A2A;
            border-left: 4px solid #F56565; display: flex; align-items: center; gap: 12px; font-weight: 600; animation: slideDown 0.4s ease;
        }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none; position: fixed; top: 18px; left: 18px; z-index: 1001; background: var(--primary);
            border: none; color: white; padding: 12px; border-radius: 10px; cursor: pointer;
            box-shadow: 0 4px 15px rgba(139, 115, 85, 0.3); transition: all 0.3s ease;
        }
        .mobile-toggle:hover { transform: scale(1.1); }
        .mobile-toggle svg { width: 24px; height: 24px; }

        @media (max-width: 968px) {
            .app-sidebar { transform: translateX(-100%); }
            .app-sidebar.active { transform: translateX(0); }
            .mobile-toggle { display: block; }
            .app-navbar { left: 0; padding-left: 70px; }
            .app-content { margin-left: 0; }
            .navbar-title { font-size: 20px; }
            .user-name, .user-role { display: none; }
        }

        @yield('styles')
    </style>
</head>
<body>

    <!-- Mobile Toggle -->
    <button class="mobile-toggle" id="mobileToggle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside class="app-sidebar" id="appSidebar">
        <div class="sidebar-header">
            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('reader.dashboard') }}" class="sidebar-logo">
                <span class="sidebar-logo-icon">📚</span>
                <span>DevDocs</span>
            </a>
        </div>

        @if(Auth::user()->isAdmin())
            <!-- Menu Admin -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Administration</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg class="sidebar-menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <svg class="sidebar-menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Gestion Contenu</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                            <svg class="sidebar-menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span>Projets</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <svg class="sidebar-menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"></path>
                            </svg>
                            <span>Catégories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.documentations.index') }}" class="{{ request()->routeIs('admin.documentations.*') ? 'active' : '' }}">
                            <svg class="sidebar-menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                            <span>Documentation</span>
                        </a>
                    </li>
                </ul>
            </div>
        @else
            <!-- Menu Reader -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Navigation</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('reader.dashboard') }}" class="{{ request()->routeIs('reader.dashboard') ? 'active' : '' }}">
                            <svg class="sidebar-menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reader.projects.index') }}" class="{{ request()->routeIs('reader.projects.*') ? 'active' : '' }}">
                            <svg class="sidebar-menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span>Projets</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reader.favoris.index') }}" class="{{ request()->routeIs('reader.favoris.*') ? 'active' : '' }}">
                            <svg class="sidebar-menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                            <span>Favoris</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </aside>

    <!-- Navbar -->
    <nav class="app-navbar">
        <h1 class="navbar-title">@yield('page-title', 'Dashboard')</h1>

        <div class="navbar-actions">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->nom }}</div>
                    <div class="user-role">{{ Auth::user()->isAdmin() ? 'Administrateur' : 'Lecteur' }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <!-- Contenu -->
    <main class="app-content">
        @if(session('success'))
            <div class="alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        const mobileToggle = document.getElementById('mobileToggle');
        const appSidebar = document.getElementById('appSidebar');

        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                appSidebar.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 968) {
                    if (!appSidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                        appSidebar.classList.remove('active');
                    }
                }
            });
        }

        @yield('scripts')
    </script>

    {{-- Bootstrap JS (Pour le fonctionnement des composants internes) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
