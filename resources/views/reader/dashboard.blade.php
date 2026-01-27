@extends('layouts.app')

@section('title', 'Dashboard - DevDocs')
@section('page-title', 'Mon Espace')

@section('styles')
{{-- J'ai gardé ton CSS exact ici, il est parfait --}}
<style>
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        padding: 40px;
        border-radius: 20px;
        color: white;
        margin-bottom: 32px;
        box-shadow: 0 8px 30px rgba(74, 124, 78, 0.25);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .welcome-banner::before {
        content: ''; position: absolute; top: -100px; right: -100px; width: 300px; height: 300px;
        background: rgba(255, 255, 255, 0.1); border-radius: 50%; animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    .welcome-content { position: relative; z-index: 1; }
    .welcome-title { font-size: 32px; font-weight: 800; margin-bottom: 10px; }
    .welcome-subtitle { font-size: 16px; opacity: 0.95; }
    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;
        margin-bottom: 32px; animation: fadeInUp 0.8s ease 0.2s both;
    }
    .stat-card {
        background: white; padding: 28px; border-radius: 16px;
        box-shadow: 0 4px 20px rgba(44, 95, 45, 0.08); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(74, 124, 78, 0.1); position: relative; overflow: hidden;
    }
    .stat-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent));
    }
    .stat-card:hover { transform: translateY(-8px); box-shadow: 0 12px 35px rgba(74, 124, 78, 0.15); }
    .stat-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    .stat-icon {
        width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center;
        font-size: 26px; background: linear-gradient(135deg, var(--accent), var(--primary-light));
        box-shadow: 0 6px 20px rgba(151, 181, 140, 0.3); transition: all 0.3s ease;
    }
    .stat-card:hover .stat-icon { transform: scale(1.1) rotate(-5deg); }
    .stat-number { font-size: 34px; font-weight: 800; color: var(--primary-dark); margin-bottom: 6px; }
    .stat-label { font-size: 14px; color: var(--text-light); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .section {
        background: white; padding: 28px; border-radius: 16px; box-shadow: 0 4px 20px rgba(44, 95, 45, 0.08);
        margin-bottom: 28px; border: 1px solid rgba(74, 124, 78, 0.1); animation: fadeInUp 0.8s ease 0.4s both;
    }
    .section-header {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;
        padding-bottom: 16px; border-bottom: 2px solid var(--background);
    }
    .section-title { font-size: 20px; font-weight: 800; color: var(--primary-dark); display: flex; align-items: center; gap: 10px; }
    .btn-action {
        padding: 10px 20px; background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 4px 15px rgba(74, 124, 78, 0.25);
    }
    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(74, 124, 78, 0.35); }
    .doc-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
    .doc-card {
        background: var(--background); padding: 20px; border-radius: 12px; border: 2px solid transparent;
        transition: all 0.3s ease; cursor: pointer; text-decoration: none; color: inherit; display: block;
    }
    .doc-card:hover { border-color: var(--accent); background: white; transform: translateY(-4px); box-shadow: 0 8px 20px rgba(74, 124, 78, 0.15); }
    .doc-title { font-weight: 700; color: var(--primary-dark); margin-bottom: 8px; font-size: 16px; }
    .doc-meta { display: flex; gap: 16px; font-size: 13px; color: var(--text-light); font-weight: 600; }
    .doc-meta-item { display: flex; align-items: center; gap: 4px; }
    .empty-state { text-align: center; padding: 60px 20px; color: var(--text-light); }
    .empty-icon { font-size: 64px; margin-bottom: 20px; opacity: 0.5; }
    .empty-text { font-size: 16px; font-weight: 600; }
    @media (max-width: 968px) {
        .stats-grid { grid-template-columns: 1fr; }
        .doc-list { grid-template-columns: 1fr; }
        .welcome-banner { padding: 30px 24px; }
        .welcome-title { font-size: 26px; }
        .section-header { flex-direction: column; gap: 12px; align-items: flex-start; }
    }
</style>
@endsection

@section('content')
    <!-- Bannière de bienvenue -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <h1 class="welcome-title">👋 Bonjour, {{ Auth::user()->nom }} !</h1>
            <p class="welcome-subtitle">Bienvenue sur votre espace de documentation</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    {{-- Utilisation de ?? 0 au cas où la variable n'est pas passée --}}
                    <div class="stat-number">{{ $docsLus ?? 0 }}</div>
                    <div class="stat-label">Documents Lus</div>
                </div>
                <div class="stat-icon">📖</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ $favorisCount ?? 0 }}</div>
                    <div class="stat-label">Favoris</div>
                </div>
                <div class="stat-icon">❤️</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-number">{{ $projetsCount ?? 0 }}</div>
                    <div class="stat-label">Projets Disponibles</div>
                </div>
                <div class="stat-icon">📁</div>
            </div>
        </div>
    </div>

    <!-- Documents Récents -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                Dernières Documentations
            </h2>
            {{-- Lien vers l'index des documentations --}}
            <a href="{{ route('reader.documentations.index') }}" class="btn-action">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                Parcourir Tout
            </a>
        </div>

        @if(isset($recentDocs) && $recentDocs->count() > 0)
            <div class="doc-list">
                @foreach($recentDocs as $doc)
                    {{-- CORRECTION : Lien réel vers le show --}}
                    <a href="{{ route('reader.documentations.show', $doc->id) }}" class="doc-card">
                        {{-- CORRECTION : Syntaxe objet ($doc->titre) et non tableau --}}
                        <h3 class="doc-title">{{ $doc->titre }}</h3>
                        <div class="doc-meta">
                            <span class="doc-meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                </svg>
                                {{-- Gestion de la catégorie liée --}}
                                {{ $doc->category->nom ?? 'Général' }}
                            </span>
                            <span class="doc-meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                {{ $doc->vues }} vues
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📄</div>
                <div class="empty-text">Aucun document récent</div>
            </div>
        @endif
    </div>

    <!-- Favoris -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                Mes Favoris Récents
            </h2>
            <a href="{{ route('reader.favoris.index') }}" class="btn-action">
                Voir Tout
            </a>
        </div>

        @if(isset($favoris) && $favoris->count() > 0)
            <div class="doc-list">
                @foreach($favoris as $favori)
                    {{-- CORRECTION : On récupère l'objet lié (Document ou Projet) --}}
                    @php
                        $item = $favori->favoritable;
                        // On détermine la route selon le type
                        $route = '#';
                        if($favori->favoritable_type === 'App\Models\Documentation') {
                            $route = route('reader.documentations.show', $favori->favoritable_id);
                        } elseif($favori->favoritable_type === 'App\Models\Project') {
                            $route = route('reader.projects.show', $favori->favoritable_id);
                        }
                    @endphp

                    @if($item)
                        <a href="{{ $route }}" class="doc-card">
                            {{-- Gestion du titre (les docs ont 'titre', les projets ont 'nom') --}}
                            <h3 class="doc-title">{{ $item->titre ?? $item->nom }}</h3>
                            <div class="doc-meta">
                                <span class="doc-meta-item">❤️ Favori</span>
                                <span class="doc-meta-item">
                                    @if($favori->favoritable_type === 'App\Models\Documentation') Doc @else Projet @endif
                                </span>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">❤️</div>
                <div class="empty-text">Aucun favori pour le moment</div>
            </div>
        @endif
    </div>
@endsection
