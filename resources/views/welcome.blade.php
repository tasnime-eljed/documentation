@extends('components.layout')

@section('title', 'Accueil - DevDocs')

@section('styles')
    <style>
        .hero-section {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, rgba(28, 77, 61, 0.05) 0%, rgba(201, 117, 127, 0.05) 100%);
            border-radius: 20px;
            margin-bottom: 60px;
        }

        .hero-title {
            font-size: 56px;
            color: #1C4D3D;
            margin-bottom: 20px;
            font-weight: 800;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 22px;
            color: #718096;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 16px 40px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .hero-btn-primary {
            background: linear-gradient(135deg, #1C4D3D 0%, #0C0C0C 100%);
            color: #FEFEFA;
            box-shadow: 0 10px 30px rgba(28, 77, 61, 0.3);
        }

        .hero-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(28, 77, 61, 0.4);
        }

        .hero-btn-secondary {
            background: white;
            color: #1C4D3D;
            border: 2px solid #1C4D3D;
        }

        .hero-btn-secondary:hover {
            background: #1C4D3D;
            color: white;
            transform: translateY(-3px);
        }

        .features-section {
            margin-top: 80px;
        }

        .features-title {
            text-align: center;
            font-size: 42px;
            color: #1C4D3D;
            margin-bottom: 60px;
            font-weight: 700;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .feature-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(28, 77, 61, 0.15);
            border-color: #C9757F;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #E2866B 0%, #C9757F 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 24px;
            color: #1C4D3D;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .feature-description {
            color: #718096;
            line-height: 1.8;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 40px;
            }

            .hero-subtitle {
                font-size: 18px;
            }

            .features-title {
                font-size: 32px;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .hero-btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="hero-section">
        <h1 class="hero-title">📚 Bienvenue sur DevDocs</h1>
        <p class="hero-subtitle">
            Votre plateforme de documentation professionnelle.
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
                En savoir plus
            </a>
        </div>
    </div>

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
                    Contrôlez qui peut accéder à votre documentation.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3 class="feature-title">Performance</h3>
                <p class="feature-description">
                    Recherche ultra-rapide et chargement instantané.
                    Accédez à votre documentation où que vous soyez.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3 class="feature-title">Collaboration</h3>
                <p class="feature-description">
                    Travaillez en équipe sur la même documentation.
                    Commentaires, révisions et gestion des versions intégrés.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🎨</div>
                <h3 class="feature-title">Personnalisable</h3>
                <p class="feature-description">
                    Adaptez l'apparence de votre documentation à votre image de marque.
                    Thèmes et templates personnalisables.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3 class="feature-title">Multi-plateforme</h3>
                <p class="feature-description">
                    Accessible sur tous vos appareils : ordinateur, tablette et mobile.
                    Design responsive et expérience optimale.
                </p>
            </div>
        </div>
    </section>
@endsection
