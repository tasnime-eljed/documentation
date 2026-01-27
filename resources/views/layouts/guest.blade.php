<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DevDocs - Documentation Professionnelle')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--background);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar Publique */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(74, 124, 78, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            animation: slideDown 0.6s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 30px var(--shadow);
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            height: 80px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: var(--primary-dark);
            font-size: 26px;
            font-weight: 800;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .logo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transition: width 0.4s ease;
            border-radius: 2px;
        }

        .logo:hover::after {
            width: 100%;
        }

        .logo:hover {
            transform: translateY(-2px);
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
            box-shadow: 0 4px 15px rgba(74, 124, 78, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 12px;
            align-items: center;
        }

        .nav-links li a {
            color: var(--text-dark);
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .nav-links li a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(74, 124, 78, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .nav-links li a:hover::before {
            left: 100%;
        }

        .nav-links li a:hover {
            background: rgba(74, 124, 78, 0.08);
            transform: translateY(-2px);
        }

        .nav-links li a.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(74, 124, 78, 0.3);
        }

        .auth-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            padding: 12px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-login {
            background: rgba(74, 124, 78, 0.1);
            color: var(--primary-dark);
            border: 2px solid var(--primary-light);
        }

        .btn-login:hover {
            background: var(--primary-light);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 124, 78, 0.3);
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 4px 15px rgba(74, 124, 78, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(74, 124, 78, 0.4);
        }

        .btn-logout {
            background: rgba(74, 124, 78, 0.1);
            color: var(--primary-dark);
            border: 2px solid var(--primary-light);
        }

        .btn-logout:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 124, 78, 0.3);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            background: var(--background);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background: #E8E5E0;
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(74, 124, 78, 0.3);
        }

        .user-name {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 15px;
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
            padding: 10px;
            background: none;
            border: none;
        }

        .menu-toggle span {
            width: 28px;
            height: 3px;
            background: var(--primary-dark);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(9px, 9px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(8px, -8px);
        }

        .content {
            padding: 0;
            max-width: 100%;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .navbar-container {
                padding: 0 20px;
                height: 70px;
            }

            .logo {
                font-size: 22px;
            }

            .logo-icon {
                width: 42px;
                height: 42px;
                font-size: 20px;
            }

            .menu-toggle {
                display: flex;
            }

            .nav-links {
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 20px;
                gap: 10px;
                transform: translateY(-150%);
                transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 10px 40px var(--shadow);
                border-bottom: 1px solid rgba(74, 124, 78, 0.1);
            }

            .nav-links.active {
                transform: translateY(0);
            }

            .auth-buttons {
                flex-direction: column;
                width: 100%;
                margin-top: 10px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .user-name {
                display: none;
            }
        }

        @yield('styles')
    </style>
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">📚</div>
                <span>DevDocs</span>
            </a>

            <ul class="nav-links" id="navLinks">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Accueil
                    </a>
                </li>

                @guest
                    <li class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-register">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            Inscription
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('reader.dashboard') }}"
                           class="{{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="user-profile">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                            </div>
                            <span class="user-name">{{ Auth::user()->nom }}</span>
                        </div>
                    </li>
                    <li class="auth-buttons">
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Déconnexion
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>

            <button class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <main class="content">
        @yield('content')
    </main>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const navbar = document.getElementById('navbar');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                menuToggle.classList.toggle('active');
                navLinks.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (!menuToggle.contains(e.target) && !navLinks.contains(e.target)) {
                    menuToggle.classList.remove('active');
                    navLinks.classList.remove('active');
                }
            });
        }

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        @yield('scripts')
    </script>
</body>
</html>
