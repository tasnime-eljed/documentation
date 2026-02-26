@extends('layouts.app')

@section('title', 'Mon Profil - DevDocs')

@section('styles')
<style>
    /* Carte Globale */
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* En-tête Profil (Carte de gauche sur Desktop) */
    .profile-card-header {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(93, 78, 55, 0.1);
        padding: 40px 20px;
        text-align: center;
        height: 100%;
        border: 1px solid rgba(139, 115, 85, 0.1);
    }

    /* Zone Avatar */
    .avatar-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto 20px;
    }

    .avatar-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 8px 20px rgba(139, 115, 85, 0.25);
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        color: white;
        font-weight: 800;
        border: 4px solid white;
        box-shadow: 0 8px 20px rgba(139, 115, 85, 0.25);
    }

    /* Bouton Caméra (Upload) */
    .avatar-edit-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: var(--primary-dark);
        color: white;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid white;
        transition: transform 0.2s;
    }
    .avatar-edit-btn:hover { transform: scale(1.1); }

    /* Bouton Supprimer Photo */
    .avatar-delete-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #F56565;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid white;
        transition: transform 0.2s;
    }
    .avatar-delete-btn:hover { transform: scale(1.1); }

    /* Carte Formulaires */
    .profile-card-body {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(93, 78, 55, 0.1);
        padding: 30px;
        border: 1px solid rgba(139, 115, 85, 0.1);
    }

    .section-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--background);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Style des Inputs (identique Login) */
    .form-label {
        font-weight: 700;
        font-size: 14px;
        color: var(--text-dark);
        margin-bottom: 8px;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E2E8F0;
        border-radius: 12px;
        background: var(--background);
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        background: white;
        outline: none;
        box-shadow: 0 4px 12px rgba(139, 115, 85, 0.1);
    }

    /* Boutons */
    .btn-save {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(139, 115, 85, 0.2);
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 115, 85, 0.3);
    }

    .alert-custom {
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .alert-success-custom {
        background: #C6F6D5; color: #22543D; border-left: 5px solid #48BB78;
    }
    .alert-error-custom {
        background: #FED7D7; color: #742A2A; border-left: 5px solid #F56565;
    }
</style>
@endsection

@section('content')
<div class="container py-5 profile-container">

    {{-- Messages de succès/erreur --}}
    @if(session('success'))
        <div class="alert-custom alert-success-custom">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-custom alert-error-custom">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        {{-- COLONNE GAUCHE : Photo & Identité --}}
        <div class="col-md-4">
            <div class="profile-card-header">
                {{-- Formulaire pour supprimer l'avatar --}}
                @if(Auth::user()->avatar)
                    <form action="{{ route('reader.profile.avatar.delete') }}" method="POST" onsubmit="return confirm('Supprimer votre photo ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="avatar-delete-btn" title="Supprimer la photo">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </form>
                @endif

                {{-- Formulaire principal (sert aussi pour l'upload d'image via JS) --}}
                <form action="{{ route('reader.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')

                    <div class="avatar-wrapper">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="avatar-image" id="avatarPreview">
                        @else
                            <div class="avatar-placeholder" id="avatarPlaceholder">
                                {{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                            </div>
                            <img src="" class="avatar-image d-none" id="avatarPreviewHidden">
                        @endif

                        {{-- Bouton Caméra (Label lié à l'input file) --}}
                        <label for="avatarInput" class="avatar-edit-btn" title="Changer la photo">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*">
                    </div>

                    <h4 class="fw-bold text-dark">{{ Auth::user()->nom }}</h4>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    <span class="badge bg-secondary px-3 py-2">Lecteur</span>
                </div>
            </div>

        {{-- COLONNE DROITE : Formulaires --}}
        <div class="col-md-8">
            <div class="profile-card-body mb-4">
                <h3 class="section-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Informations de base
                </h3>

                {{-- Les champs sont dans le formulaire "profileForm" qui englobe aussi l'image techniquement,
                     mais ici on répète les inputs pour la clarté visuelle ou on utilise le form ID --}}

                <div class="mb-3">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="nom" class="form-control-custom" value="{{ old('nom', Auth::user()->nom) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" name="email" class="form-control-custom" value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn-save">
                        Enregistrer les modifications
                    </button>
                </div>
                </form> {{-- Fin du formulaire principal --}}
            </div>

            {{-- Formulaire Mot de passe --}}
            <div class="profile-card-body">
                <h3 class="section-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Sécurité
                </h3>

                <form action="{{ route('reader.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-control-custom" required placeholder="••••••••">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control-custom" required placeholder="8 caractères min.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirmer nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control-custom" required placeholder="Répéter">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn-save" style="background: var(--text-dark);">
                            Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Prévisualisation de l'image dès qu'on en sélectionne une
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarPreviewHidden = document.getElementById('avatarPreviewHidden');
    const avatarPlaceholder = document.getElementById('avatarPlaceholder');

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (avatarPreview) {
                        avatarPreview.src = e.target.result;
                    } else {
                        // Si l'utilisateur n'avait pas d'image, on cache le placeholder et on montre l'img
                        if(avatarPlaceholder) avatarPlaceholder.style.display = 'none';
                        if(avatarPreviewHidden) {
                            avatarPreviewHidden.src = e.target.result;
                            avatarPreviewHidden.classList.remove('d-none');
                        }
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endsection
