@extends('layouts.guest')

@section('title', $documentation->titre . ' - Document Partagé')

{{-- AJOUT : CSS Spécifique pour rendre le document joli (Style Word) --}}
@section('styles')
<style>
    /* Zone de contenu principale */
    .documentation-content {
        font-family: 'Calibri', 'Segoe UI', 'Arial', sans-serif; /* Police type Word */
        font-size: 1.15rem; /* Texte lisible */
        line-height: 1.6;
        color: #2c3e50;
    }

    /* Rétablir les puces (points) */
    .documentation-content ul {
        list-style-type: disc !important;
        padding-left: 2rem !important;
        margin-bottom: 1rem;
    }

    /* Rétablir les numéros (1. 2. 3.) */
    .documentation-content ol {
        list-style-type: decimal !important;
        padding-left: 2rem !important;
        margin-bottom: 1rem;
    }

    /* Espacement des éléments de liste */
    .documentation-content li {
        margin-bottom: 0.5rem;
    }

    /* Titres (H1, H2...) en vert/sombre */
    .documentation-content h1,
    .documentation-content h2,
    .documentation-content h3 {
        color: #1a202c;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
        line-height: 1.3;
    }

    /* Liens */
    .documentation-content a {
        color: #3b82f6;
        text-decoration: underline;
    }

    /* Images */
    .documentation-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin: 1.5rem 0;
        display: block;
    }

    /* Tableaux */
    .documentation-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
    }
    .documentation-content td,
    .documentation-content th {
        border: 1px solid #e2e8f0;
        padding: 0.75rem;
    }
    .documentation-content th {
        background-color: #f7fafc;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9"> {{-- Un peu plus large pour ressembler à une feuille A4 --}}

            {{-- En-tête du document --}}
            <div class="text-center mb-5">
                <span class="badge bg-warning text-dark mb-2 px-3 py-2 rounded-pill">Document Partagé</span>
                <h1 class="fw-bold display-5 text-dark mb-3 mt-2">
                    {{ $documentation->titre }}
                </h1>
                <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">
                    <i class="bi bi-clock me-1"></i> {{ $documentation->temps_lecture }} min de lecture
                    <span class="mx-2">&bull;</span>
                    Mis à jour {{ $documentation->updated_at->diffForHumans() }}
                </div>
            </div>

            {{-- Contenu du document --}}
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5 bg-white">

                    {{-- Fil d'ariane contextuel --}}
                    <div class="mb-4 pb-3 border-bottom">
                        <small class="text-muted text-uppercase fw-bold" style="letter-spacing: 1px;">
                            {{ $documentation->category->project->nom ?? 'Projet' }}
                            <span class="mx-2">/</span>
                            {{ $documentation->category->nom ?? 'Catégorie' }}
                        </small>
                    </div>

                    {{--
                        CORRECTION MAJEURE ICI :
                        On utilise {!! ... !!} pour afficher le HTML de TinyMCE (gras, listes...)
                        et on applique la classe CSS définie plus haut.
                    --}}
                    <div class="documentation-content">
                        {!! $documentation->contenu !!}
                    </div>

                </div>
            </div>

            {{-- Pied de page --}}
            <div class="text-center mt-5 text-muted">
                <p class="small">Ce document est partagé via la plateforme <strong>DevDocs</strong>.</p>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                    Se connecter
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
