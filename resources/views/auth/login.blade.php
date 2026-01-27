@extends('layouts.guest')

@section('title', 'Connexion - DevDocs')

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

    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, rgba(139, 115, 85, 0.03) 0%, rgba(184, 149, 106, 0.05) 100%);
    }

    .auth-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(93, 78, 55, 0.15);
        overflow: hidden;
        max-width: 1100px;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-form-section {
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .auth-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin-bottom: 20px;
        animation: bounceIn 0.8s ease;
        box-shadow: 0 8px 24px rgba(139, 115, 85, 0.3);
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .auth-title {
        color: var(--primary-dark);
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 10px;
        animation: fadeInDown 0.8s ease 0.2s both;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-subtitle {
        color: var(--text-light);
        font-size: 16px;
        animation: fadeInUp 0.8s ease 0.3s both;
    }

    .form-group {
        margin-bottom: 24px;
        animation: fadeInUp 0.8s ease both;
    }

    .form-group:nth-child(1) { animation-delay: 0.4s; }
    .form-group:nth-child(2) { animation-delay: 0.5s; }

    .form-label {
        display: block;
        margin-bottom: 10px;
        color: var(--text-dark);
        font-weight: 700;
        font-size: 14px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-light);
        width: 20px;
        height: 20px;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .form-input {
        width: 100%;
        padding: 16px 18px 16px 52px;
        border: 2px solid #E2E8F0;
        border-radius: 12px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: var(--background);
    }

    .form-input::placeholder {
        color: #A0AEC0;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 115, 85, 0.15);
    }

    .form-input:focus ~ .input-icon {
        color: var(--primary);
        transform: translateY(-50%) scale(1.1);
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        font-size: 14px;
        animation: fadeIn 0.8s ease 0.6s both;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--text-dark);
        font-weight: 600;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .forgot-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .forgot-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .btn-primary {
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        animation: fadeInUp 0.8s ease 0.7s both;
        box-shadow: 0 6px 20px rgba(139, 115, 85, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
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

    .btn-primary:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(139, 115, 85, 0.4);
    }

    .divider {
        text-align: center;
        margin: 30px 0;
        position: relative;
        animation: fadeIn 0.8s ease 0.8s both;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #E2E8F0;
    }

    .divider span {
        background: white;
        padding: 0 16px;
        color: var(--text-light);
        position: relative;
        font-size: 14px;
        font-weight: 700;
    }

    .toggle-auth {
        text-align: center;
        margin-top: 24px;
        color: var(--text-light);
        animation: fadeIn 0.8s ease 0.9s both;
        font-weight: 600;
    }

    .toggle-auth a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 800;
        transition: all 0.3s ease;
    }

    .toggle-auth a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .auth-illustration {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--accent) 100%);
        padding: 60px 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .auth-illustration::before,
    .auth-illustration::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
    }

    .auth-illustration::before {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
    }

    .auth-illustration::after {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation-delay: 2s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .illustration-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }

    .illustration-icon {
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

    .illustration-content h3 {
        font-size: 38px;
        font-weight: 800;
        margin-bottom: 20px;
        animation: fadeInRight 1s ease 0.3s both;
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .illustration-content p {
        font-size: 17px;
        opacity: 0.95;
        line-height: 1.7;
        animation: fadeInRight 1s ease 0.5s both;
    }

    .alert-error {
        background: #FED7D7;
        color: #742A2A;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
        border-left: 4px solid #F56565;
        animation: shake 0.5s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    @media (max-width: 968px) {
        .auth-card {
            grid-template-columns: 1fr;
        }

        .auth-illustration {
            min-height: 250px;
            order: -1;
        }

        .auth-form-section {
            padding: 40px 30px;
        }

        .auth-title {
            font-size: 28px;
        }

        .illustration-content h3 {
            font-size: 32px;
        }

        .form-options {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-form-section">
            <div class="auth-header">
                <div class="auth-logo">📚</div>
                <h2 class="auth-title">Bienvenue !</h2>
                <p class="auth-subtitle">Connectez-vous pour accéder à votre espace</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Adresse email</label>
                    <div class="input-wrapper">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="votre@email.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="••••••••"
                            required
                        >
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="remember">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-primary">
                    Se connecter
                </button>
            </form>

            <div class="divider">
                <span>OU</span>
            </div>

            <div class="toggle-auth">
                Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a>
            </div>
        </div>

        <div class="auth-illustration">
            <div class="illustration-content">
                <div class="illustration-icon">📚</div>
                <h3>DevDocs</h3>
                <p>Gérez votre documentation<br>professionnelle en toute simplicité</p>
            </div>
        </div>
    </div>
</div>
@endsection
