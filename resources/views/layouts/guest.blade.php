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

    {{-- Icons Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Reset basique */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary-dark: #2C5F2D;
            --primary: #4A7C4E;
            --primary-light: #7FA97F;
            --secondary-dark: #8B7355;
            --secondary: #B8A58C;
            --secondary-light: #D4C5B0;
            --accent: #97B58C;
            --background: #F5F3F0;
            --white: #FFFFFF;
            --text-dark: #2D3748;
            --text-light: #718096;
            --shadow: rgba(44, 95, 45, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
            padding-top: 80px;
        }

        /* --- NAVBAR PERSONNALISÉE --- */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(74, 124, 78, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
            transition: all 0.3s ease;
            height: 80px;
            display: flex;
            align-items: center;
        }

        .navbar-custom.scrolled {
            box-shadow: 0 4px 30px var(--shadow);
        }

        .navbar-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
        }

        /* Logo */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none !important;
            color: var(--primary-dark) !important;
            font-size: 26px;
            font-weight: 800;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 4px 15px rgba(74, 124, 78, 0.3);
        }

        /* Liens de navigation */
        .custom-nav-links {
            display: flex;
            list-style: none;
            gap: 12px;
            align-items: center;
            margin-bottom: 0;
        }

        .custom-nav-link {
            color: var(--text-dark);
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .custom-nav-link:hover {
            background: rgba(74, 124, 78, 0.08);
            color: var(--primary);
        }

        .custom-nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(74, 124, 78, 0.3);
        }

        /* Boutons Auth */
        .btn-custom-login {
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid var(--primary-light);
            color: var(--primary-dark);
            background: transparent;
            transition: all 0.3s ease;
        }
        .btn-custom-login:hover {
            background: var(--primary-light);
            color: white;
        }

        .btn-custom-register {
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-custom-register:hover {
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 8px 25px rgba(74, 124, 78, 0.4);
        }

        /* Profil Utilisateur */
        .user-profile-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 16px;
            background: #E8E5E0;
            border-radius: 12px;
        }
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Toggle Menu Mobile */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
        }
        .menu-toggle span {
            width: 28px;
            height: 3px;
            background: var(--primary-dark);
            border-radius: 3px;
        }

        /* Content Wrapper */
        .content-wrapper {
            padding-top: 20px;
        }

        /* =============================================================
           STYLE DOCUMENTATION (Pour TinyMCE / Reader)
           ============================================================= */
        .documentation-content {
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        /* IMPORTANT : Rétablir les puces écrasées par le reset '*' */
        .documentation-content ul {
            list-style-type: disc !important;
            padding-left: 2rem !important;
            margin-bottom: 1rem;
        }
        .documentation-content ol {
            list-style-type: decimal !important;
            padding-left: 2rem !important;
            margin-bottom: 1rem;
        }
        .documentation-content li {
            margin-bottom: 0.5rem;
        }

        /* Titres dans le contenu */
        .documentation-content h1,
        .documentation-content h2,
        .documentation-content h3,
        .documentation-content h4 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        /* Images */
        .documentation-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin: 1.5rem auto;
            display: block;
        }

        /* Tableaux */
        .documentation-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: 0.95rem;
        }
        .documentation-content th,
        .documentation-content td {
            border: 1px solid #e5e7eb;
            padding: 0.75rem;
            text-align: left;
        }
        .documentation-content th {
            background-color: #f3f4f6;
            font-weight: 600;
        }

        /* Liens */
        .documentation-content a {
            color: var(--primary);
            text-decoration: underline;
            font-weight: 500;
        }

        /* Citations */
        .documentation-content blockquote {
            border-left: 4px solid var(--primary-light);
            padding-left: 1rem;
            font-style: italic;
            color: #4b5563;
            margin: 1.5rem 0;
            background: #f9fafb;
            padding: 1rem;
            border-radius: 0 8px 8px 0;
        }

        /* Mobile Responsiveness */
        @media (max-width: 968px) {
            .navbar-container { padding: 0 20px; }
            .menu-toggle { display: flex; }
            .custom-nav-links {
                position: absolute;
                top: 80px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 20px;
                display: none;
                box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            }
            .custom-nav-links.active { display: flex; }
        }

        @yield('styles')
    </style>
</head>
<body>

    {{-- Navigation --}}
    <nav class="navbar-custom" id="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="nav-logo">
                <div class="logo-icon">📚</div>
                <span>DevDocs</span>
            </a>

            <ul class="custom-nav-links" id="navLinks">
                <li>
                    <a href="{{ route('home') }}" class="custom-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house"></i> Accueil
                    </a>
                </li>

                @guest
                    <li class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn-custom-login">Connexion</a>
                        <a href="{{ route('register') }}" class="btn-custom-register">Inscription</a>
                    </li>
                @else
                    <li>
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('reader.dashboard') }}"
                           class="custom-nav-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                           <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-profile-badge">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                                </div>
                                <span class="fw-bold d-none d-lg-block">{{ Auth::user()->nom }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle p-2" title="Déconnexion">
                                    <i class="bi bi-power"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

            <button class="menu-toggle" id="menuToggle">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    {{-- Contenu Principal --}}
    <main class="content-wrapper">
        @yield('content')
    </main>

    {{-- Scripts --}}
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const navbar = document.getElementById('navbar');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }

        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
