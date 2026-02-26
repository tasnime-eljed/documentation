@extends('layouts.guest')

@section('title', 'Mot de passe oublié - DevDocs')

{{-- On réutilise exactement le même CSS que Login/Register --}}
@section('styles')
<style>
    /* ... (Le même CSS que login.blade.php) ... */
    /* Je ne remets pas tout le bloc CSS ici pour ne pas surcharger,
       mais assure-toi de copier le bloc <style> de login.blade.php ici
       ou de mettre ce CSS dans un fichier public/css/auth.css */

    /* Astuce : Si tu ne veux pas copier-coller le CSS, dis-le moi,
       on peut créer un fichier CSS commun */

    /* Pour l'instant, copie le bloc <style> de login.blade.php ici */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    :root { --primary-dark: #5D4E37; --primary: #8B7355; --accent: #B8956A; --background: #FAF8F5; }
    /* ... COPIE LE CSS DE LOGIN ICI ... */
</style>
{{-- Pour faire simple, je suppose que tu as copié le style de login ici --}}
{{-- Si tu as mis le CSS dans un fichier à part, c'est encore mieux --}}
<link rel="stylesheet" href="{{ asset('css/auth-custom.css') }}">
{{-- (Si tu n'as pas de fichier CSS séparé, copie le contenu de la balise <style> de login.blade.php ici) --}}
@endsection

@section('content')
<style>
    /* Rappel rapide des styles essentiels si tu ne copies pas tout */
    .auth-container { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #FAF8F5; padding: 20px; }
    .auth-card { background: white; border-radius: 24px; box-shadow: 0 20px 60px rgba(93,78,55,0.15); max-width: 500px; width: 100%; padding: 40px; text-align: center; }
    .auth-logo { font-size: 40px; margin-bottom: 20px; display: inline-block; }
    .btn-primary { background: linear-gradient(135deg, #8B7355, #B8956A); color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: bold; width: 100%; cursor: pointer; margin-top: 20px; }
    .form-input { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; margin-top: 5px; }
    .alert-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; }
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo">🔑</div>
        <h2 style="color: #5D4E37; margin-bottom: 10px; font-weight: 800;">Récupération</h2>
        <p style="color: #718096; margin-bottom: 30px; font-size: 15px;">
            Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="color: red; font-size: 14px; margin-bottom: 15px; text-align: left;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div style="text-align: left; margin-bottom: 15px;">
                <label style="font-weight: 700; color: #2D3748; font-size: 14px;">Adresse Email</label>
                <input type="email" name="email" class="form-input" placeholder="exemple@gmail.com" required autofocus value="{{ old('email') }}">
            </div>

            <button type="submit" class="btn-primary">
                Envoyer le lien de réinitialisation
            </button>
        </form>

        <div style="margin-top: 25px;">
            <a href="{{ route('login') }}" style="color: #718096; text-decoration: none; font-size: 14px;">
                &larr; Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection
