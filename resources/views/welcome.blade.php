@extends('layouts.guest')

@section('title', 'Accueil - DevDocs')

@section('styles')
<style>
    :root {
        --primary-dark: #5D4E37;
        --primary: #8B7355;
        --primary-light: #A0826D;
        --secondary: #D4A574;
        --accent: #B8956A;
        --background: #FAF8F5;
        --text-dark: #2D3748;
        --text-light: #718096;
    }

    .content {
        padding: 0 !important;
    }

    /* Hero Section */
    .hero-section {
        text-align: center;
        padding: 120px 40px;
        background: linear-gradient(135deg, rgba(139, 115, 85, 0.05) 0%, rgba(184, 149, 106, 0.08) 100%);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.8s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-section::before,
    .hero-section::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(184, 149, 106, 0.15), transparent);
        animation: pulse 8s ease-in-out infinite;
    }

    .hero-section::before {
        width: 500px;
        height: 500px;
        top: -200px;
        right: -200px;
    }

    .hero-section::after {
        width: 400px;
        height: 400px;
        bottom: -150px;
        left: -150px;
        animation-delay: 2s;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 0.3;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.5;
        }
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-icon {
        font-size: 100px;
        margin-bottom: 30px;
        animation: floatIcon 4s ease-in-out infinite;
        display: inline-block;
    }

    @keyframes floatIcon {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        25% {
            transform: translateY(-15px) rotate(-5deg);
        }
        50% {
            transform: translateY(-25px) rotate(0deg);
        }
        75% {
            transform: translateY(-15px) rotate(5deg);
        }
    }

    .hero-title {
        font-size: 58px;
        color: var(--primary-dark);
        margin-bottom: 24px;
        font-weight: 800;
        line-height: 1.2;
        animation: fadeInDown 1s ease 0.2s both;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-subtitle {
        font-size: 22px;
        color: var(--text-light);
        margin-bottom: 50px;
        max-width: 750px;
        margin-left: auto;
        margin-right: auto;
        animation: fadeInUp 1s ease 0.4s both;
        line-height: 1.7;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        animation: fadeInUp 1s ease 0.6s both;
    }

    .hero-btn {
        padding: 18px 45px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 800;
        font-size: 17px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
    }

    .hero-btn::before {
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

    .hero-btn:hover::before {
        width: 400px;
        height: 400px;
    }

    .hero-btn-primary {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        color: white;
        box-shadow: 0 10px 30px rgba(139, 115, 85, 0.35);
    }

    .hero-btn-primary:hover {
        transform: translateY(-6px) scale(1.05);
        box-shadow: 0 15px 45px rgba(139, 115, 85, 0.45);
    }

    .hero-btn-secondary {
        background: white;
        color: var(--primary-dark);
        border: 2px solid var(--primary);
    }

    .hero-btn-secondary:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-6px) scale(1.05);
        box-shadow: 0 10px 35px rgba(139, 115, 85, 0.3);
    }

    /* Features Section */
    .features-section {
        padding: 100px 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .features-title {
        text-align: center;
        font-size: 44px;
        color: var(--primary-dark);
        margin-bottom: 70px;
        font-weight: 800;
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .features-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 5px;
        background: linear-gradient(90deg, var(--primary), var(--accent));
        border-radius: 3px;
        animation: expandWidth 1.5s ease 0.5s both;
    }

    @keyframes expandWidth {
        from { width: 0; }
        to { width: 100px; }
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
    }

    .feature-card {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(93, 78, 55, 0.1);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.8s ease both;
    }

    .feature-card:nth-child(1) { animation-delay: 0.1s; }
    .feature-card:nth-child(2) { animation-delay: 0.2s; }
    .feature-card:nth-child(3) { animation-delay: 0.3s; }
    .feature-card:nth-child(4) { animation-delay: 0.4s; }
    .feature-card:nth-child(5) { animation-delay: 0.5s; }
    .feature-card:nth-child(6) { animation-delay: 0.6s; }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(184, 149, 106, 0.15), transparent);
        transition: left 0.6s;
    }

    .feature-card:hover::before {
        left: 100%;
    }

    .feature-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 50px rgba(139, 115, 85, 0.2);
        border-color: var(--accent);
    }

    .feature-icon {
        width: 75px;
        height: 75px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        margin-bottom: 24px;
        transition: all 0.4s ease;
        box-shadow: 0 6px 20px rgba(139, 115, 85, 0.3);
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.15) rotate(-8deg);
        box-shadow: 0 12px 35px rgba(139, 115, 85, 0.4);
    }

    .feature-title {
        font-size: 24px;
        color: var(--primary-dark);
        margin-bottom: 16px;
        font-weight: 800;
        transition: color 0.3s ease;
    }

    .feature-card:hover .feature-title {
        color: var(--primary);
    }

    .feature-description {
        color: var(--text-light);
        line-height: 1.8;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    .feature-card:hover .feature-description {
        color: var(--text-dark);
    }

    /* Scroll Indicator */
    .scroll-indicator {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        animation: bounceUpDown 2s ease-in-out infinite;
    }

    .scroll-indicator svg {
        width: 32px;
        height: 32px;
        color: var(--primary);
    }

    @keyframes bounceUpDown {
        0%, 100% {
            transform: translate(-50%, 0);
        }
        50% {
            transform: translate(-50%, -12px);
        }
    }

    /* Responsive */
    @media (max-width: 968px) {
        .hero-section {
            padding: 80px 30px;
        }

        .hero-title {
            font-size: 42px;
        }

        .hero-subtitle {
            font-size: 18px;
        }

        .features-title {
            font-size: 36px;
        }

        .features-section {
            padding: 70px 30px;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }

        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }

        .hero-btn {
            width: 100%;
            max-width: 350px;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-icon">📚</div>
            <h1 class="hero-title">Bienvenue sur DevDocs</h1>
            <p class="hero-subtitle">
                Votre plateforme de documentation professionnelle moderne.
                Créez, organisez et partagez votre documentation technique en toute simplicité.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="hero-btn hero-btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    Commencer Gratuitement
                </a>
                <a href="#features" class="hero-btn hero-btn-secondary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 16v-4M12 8h.01"></path>
                    </svg>
                    Découvrir les Fonctionnalités
                </a>
            </div>
        </div>
        <div class="scroll-indicator">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M19 12l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <h2 class="features-title">✨ Fonctionnalités Principales</h2>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📝</div>
                <h3 class="feature-title">Éditeur Intuitif</h3>
                <p class="feature-description">
                    Créez votre documentation avec un éditeur moderne et facile à utiliser.
                    Support complet du Markdown et prévisualisation en temps réel.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3 class="feature-title">Sécurisé</h3>
                <p class="feature-description">
                    Vos données sont protégées avec un cryptage de niveau entreprise.
                    Contrôlez précisément qui peut accéder à votre documentation.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3 class="feature-title">Performance</h3>
                <p class="feature-description">
                    Recherche ultra-rapide et chargement instantané de vos documents.
                    Accédez à votre documentation où que vous soyez.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3 class="feature-title">Collaboration</h3>
                <p class="feature-description">
                    Travaillez en équipe sur la même documentation avec des rôles définis.
                    Partage sécurisé et gestion des accès simplifiée.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🎨</div>
                <h3 class="feature-title">Organisation</h3>
                <p class="feature-description">
                    Structurez votre documentation par projets et catégories.
                    Retrouvez facilement vos documents avec un système de favoris.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3 class="feature-title">Multi-plateforme</h3>
                <p class="feature-description">
                    Accessible sur tous vos appareils : ordinateur, tablette et mobile.
                    Interface responsive et expérience utilisateur optimale.
                </p>
            </div>
        </div>
    </section>
@endsection
