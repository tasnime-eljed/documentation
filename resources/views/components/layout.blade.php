<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DevDocs - Documentation')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #FEFEFA;
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #1C4D3D 0%, #0C0C0C 100%);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            animation: slideDown 0.5s ease;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            height: 70px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #FEFEFA;
            font-size: 26px;
            font-weight: 700;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(254, 254, 250, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            backdrop-filter: blur(10px);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 8px;
            align-items: center;
        }

        .nav-links li a {
            color: #FEFEFA;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
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
            background: rgba(254, 254, 250, 0.1);
            transition: left 0.3s ease;
        }

        .nav-links li a:hover::before {
            left: 0;
        }

        .nav-links li a:hover {
            background: rgba(254, 254, 250, 0.15);
            transform: translateY(-2px);
        }

        .nav-links li a.active {
            background: rgba(254, 254, 250, 0.25);
        }

        .auth-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
        }

        .btn-login {
            background: rgba(254, 254, 250, 0.15);
            color: #FEFEFA;
            backdrop-filter: blur(10px);
        }

        .btn-login:hover {
            background: #E2866B;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(226, 134, 107, 0.4);
        }

        .btn-register {
            background: linear-gradient(135deg, #C9757F 0%, #E2866B 100%);
            color: #FEFEFA;
            box-shadow: 0 4px 15px rgba(201, 117, 127, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(226, 134, 107, 0.5);
        }

        .btn-logout {
            background: rgba(254, 254, 250, 0.1);
            color: #FEFEFA;
            border: 2px solid rgba(254, 254, 250, 0.3);
        }

        .btn-logout:hover {
            background: #C9757F;
            border-color: #C9757F;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(201, 117, 127, 0.4);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: rgba(254, 254, 250, 0.1);
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E2866B 0%, #C9757F 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FEFEFA;
            font-weight: 700;
            font-size: 16px;
        }

        .user-name {
            color: #FEFEFA;
            font-weight: 600;
            font-size: 14px;
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 8px;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background: #FEFEFA;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .icon {
            width: 18px;
            height: 18px;
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

        .content {
            padding: 40px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .navbar-container {
                padding: 0 20px;
            }

            .menu-toggle {
                display: flex;
            }

            .nav-links {
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, #1C4D3D 0%, #0C0C0C 100%);
                flex-direction: column;
                padding: 20px;
                gap: 10px;
                transform: translateY(-150%);
                transition: transform 0.3s ease;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
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

            .user-profile {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 22px;
            }

            .logo-icon {
                width: 35px;
                height: 35px;
                font-size: 20px;
            }

            .navbar-container {
                height: 65px;
            }
        }

        @yield('styles')
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">📚</div>
                <span>DevDocs</span>
            </a>

            <ul class="nav-links" id="navLinks">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Home
                    </a>
                </li>

                @guest
                    <li class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-register">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            Register
                        </a>
                    </li>
                @else
                    <li>
                        <div class="user-profile">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                        </div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <main class="content">
        @yield('content')
    </main>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

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

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                menuToggle.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });

        @yield('scripts')
    </script>
</body>
</html>
