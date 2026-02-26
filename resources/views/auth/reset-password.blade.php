@extends('layouts.guest')

@section('title', 'Nouveau mot de passe')

@section('content')
<style>
    /* Styles simplifiés pour correspondre */
    .auth-container { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #FAF8F5; padding: 20px; }
    .auth-card { background: white; border-radius: 24px; box-shadow: 0 20px 60px rgba(93,78,55,0.15); max-width: 500px; width: 100%; padding: 40px; }
    .btn-primary { background: linear-gradient(135deg, #8B7355, #B8956A); color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: bold; width: 100%; cursor: pointer; margin-top: 20px; }
    .form-input { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; margin-top: 5px; }
    .form-group { margin-bottom: 15px; }
</style>

<div class="auth-container">
    <div class="auth-card">
        <h2 style="color: #5D4E37; margin-bottom: 25px; text-align: center; font-weight: 800;">Nouveau mot de passe</h2>

        @if ($errors->any())
            <div style="color: red; font-size: 14px; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label style="font-weight: 700; font-size: 14px;">Adresse Email</label>
                <input type="email" name="email" class="form-input" value="{{ $email ?? old('email') }}" required>
            </div>

            <div class="form-group">
                <label style="font-weight: 700; font-size: 14px;">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-input" required autofocus>
            </div>

            <div class="form-group">
                <label style="font-weight: 700; font-size: 14px;">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <button type="submit" class="btn-primary">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>
</div>
@endsection
