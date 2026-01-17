@extends('components.layout')

@section('title', 'Inscription - DevDocs')

@section('styles')
<style>
    .content {
        padding: 0 !important;
        margin: 0 !important;
        max-width: 100% !important;
    }

    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 70px);
        padding: 20px;
    }

    .auth-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 1000px;
        width: 100%;
        display: flex;
        animation: fadeIn 0.5s ease;
    }

    .auth-form-section {
        flex: 1;
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .auth-logo-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #E2866B 0%, #C9757F 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        animation: fadeInDown 0.8s ease;
    }

    .auth-title {
        color: #1C4D3D;
        margin-bottom: 10px;
        font-size: 32px;
        font-weight: 700;
        text-align: center;
        animation: fadeInLeft 0.8s ease;
    }

    .auth-subtitle {
        color: #718096;
        margin-bottom: 30px;
        font-size: 16px;
        text-align: center;
        animation: fadeInLeft 0.8s ease 0.1s both;
    }

    .form-group {
        margin-bottom: 20px;
        animation: fadeInUp 0.8s ease;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #4a5568;
        font-weight: 600;
        font-size: 14px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 18px;
        color: #a0aec0;
        width: 20px;
        height: 20px;
        pointer-events: none;
    }

    .form-input {
        width: 100%;
        padding: 14px 18px 14px 50px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f7fafc;
        font-family: inherit;
    }

    .form-input::placeholder {
        color: #a0aec0;
    }

    .form-input:focus {
        outline: none;
        border-color: #C9757F;
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(201, 117, 127, 0.2);
    }

    .password-strength {
        margin-top: 8px;
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        overflow: hidden;
        display: none;
    }

    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-weak {
        width: 33%;
        background: #f56565;
    }

    .strength-medium {
        width: 66%;
        background: #ed8936;
    }

    .strength-strong {
        width: 100%;
        background: #48bb78;
    }

    .terms-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        color: #4a5568;
    }

    .terms-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #C9757F;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .terms-checkbox a {
        color: #C9757F;
        text-decoration: none;
        font-weight: 600;
    }

    .terms-checkbox a:hover {
        text-decoration: underline;
    }

    .btn-primary {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #1C4D3D 0%, #0C0C0C 100%);
        color: #FEFEFA;
        animation: fadeInUp 0.8s ease 0.3s both;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(28, 77, 61, 0.4);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .divider {
        text-align: center;
        margin: 25px 0;
        position: relative;
        animation: fadeIn 0.8s ease 0.4s both;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e2e8f0;
    }

    .divider span {
        background: white;
        padding: 0 15px;
        color: #a0aec0;
        position: relative;
        z-index: 1;
        font-size: 14px;
    }

    .social-buttons {
        display: flex;
        gap: 15px;
        animation: fadeInUp 0.8s ease 0.5s both;
    }

    .btn-social {
        flex: 1;
        padding: 12px;
        border: 2px solid #e2e8f0;
        background: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: #4a5568;
        font-size: 14px;
    }

    .btn-social:hover {
        border-color: #C9757F;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .toggle-auth {
        text-align: center;
        margin-top: 25px;
        color: #718096;
        animation: fadeIn 0.8s ease 0.6s both;
        font-size: 14px;
    }

    .toggle-auth a {
        color: #C9757F;
        text-decoration: none;
        font-weight: 700;
    }

    .toggle-auth a:hover {
        text-decoration: underline;
    }

    .auth-illustration {
        flex: 1;
        background: linear-gradient(135deg, #1C4D3D 0%, #0C0C0C 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .auth-illustration::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(254, 254, 250, 0.1);
        border-radius: 50%;
        top: -100px;
        right: -100px;
        animation: float 6s ease-in-out infinite;
    }

    .auth-illustration::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(254, 254, 250, 0.1);
        border-radius: 50%;
        bottom: -50px;
        left: -50px;
        animation: float 8s ease-in-out infinite;
    }

    .illustration-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: #FEFEFA;
    }

    .illustration-icon {
        font-size: 80px;
        margin-bottom: 20px;
        animation: bookFloat 3s ease-in-out infinite, fadeInRight 0.8s ease;
        display: inline-block;
    }

    .illustration-content h3 {
        font-size: 36px;
        margin-bottom: 20px;
        font-weight: 700;
        animation: slideInFromRight 1s ease 0.1s both;
    }

    .illustration-content p {
        font-size: 16px;
        opacity: 0.9;
        line-height: 1.6;
        animation: fadeInRight 0.8s ease 0.2s both;
    }

    .error-message {
        background: #fee;
        color: #c00;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        animation: shake 0.5s ease;
    }

    .success-message {
        background: #d4edda;
        color: #155724;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
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

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes bookFloat {
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

    @keyframes slideInFromRight {
        0% {
            opacity: 0;
            transform: translateX(50px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    @media (max-width: 768px) {
        .auth-card {
            flex-direction: column;
        }

        .auth-illustration {
            min-height: 200px;
        }

        .auth-form-section {
            padding: 40px 30px;
        }

        .auth-title {
            font-size: 28px;
        }

        .illustration-content h3 {
            font-size: 28px;
        }

        .social-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-form-section">
            <div class="auth-logo">
                <div class="auth-logo-icon">📚</div>
            </div>

            <h2 class="auth-title">Inscription</h2>
            <p class="auth-subtitle">Créez votre compte pour commencer</p>

            @if ($errors->any())
                <div class="error-message">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nom complet</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input"
                            placeholder="Votre nom complet"
                            value="{{ old('name') }}"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="votre@email.com"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="••••••••"
                            required
                            minlength="8"
                        >
                    </div>
                    <div class="password-strength" id="passwordStrength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="M9 12l2 2 4-4"></path>
                        </svg>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="••••••••"
                            required
                            minlength="8"
                        >
                    </div>
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a>
                    </label>
                </div>

                <button type="submit" class="btn-primary">
                    S'inscrire
                </button>
            </form>

            <div class="divider">
                <span>OU</span>
            </div>

            <div class="social-buttons">
                <a href="#" class="btn-social">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#4285F4" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#34A853" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    S'inscrire avec Google
                </a>
                <a href="#" class="btn-social">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    S'inscrire avec Facebook
                </a>
            </div>

            <div class="toggle-auth">
                Déjà inscrit? <a href="{{ route('login') }}">Se connecter</a>
            </div>
        </div>

        <div class="auth-illustration">
            <div class="illustration-content">
                <div class="illustration-icon">📚</div>
                <h3>DevDocs</h3>
                <p>Rejoignez-nous et commencez<br>à documenter vos projets</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthIndicator = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');

    passwordInput.addEventListener('input', function() {
        const password = this.value;

        if (password.length === 0) {
            strengthIndicator.style.display = 'none';
            return;
        }

        strengthIndicator.style.display = 'block';

        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;

        strengthBar.className = 'password-strength-bar';

        if (strength <= 1) {
            strengthBar.classList.add('strength-weak');
        } else if (strength <= 3) {
            strengthBar.classList.add('strength-medium');
        } else {
            strengthBar.classList.add('strength-strong');
        }
    });

    // Confirm password validation
    const form = document.getElementById('registerForm');
    const confirmPassword = document.getElementById('password_confirmation');

    form.addEventListener('submit', function(e) {
        if (passwordInput.value !== confirmPassword.value) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas!');
            confirmPassword.focus();
        }
    });
</script>
@endsection
