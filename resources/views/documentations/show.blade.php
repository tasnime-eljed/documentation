@extends('layouts.app')

@section('title', $documentation->titre)

{{-- AJOUT : CSS Spécifique pour le rendu "Word" --}}
@section('styles')
<style>
    .documentation-content {
        font-family: 'Calibri', 'Segoe UI', sans-serif; /* Police standard Word */
        font-size: 1.1rem;
        line-height: 1.6;
        color: #212529;
    }

    /* Force l'affichage des puces (points) */
    .documentation-content ul {
        list-style-type: disc !important;
        padding-left: 2.5rem !important;
        margin-bottom: 1rem;
    }

    /* Force l'affichage des numéros (1. 2. 3.) */
    .documentation-content ol {
        list-style-type: decimal !important;
        padding-left: 2.5rem !important;
        margin-bottom: 1rem;
    }

    .documentation-content li {
        margin-bottom: 0.5rem;
    }

    /* Style des titres H1, H2, etc. générés par l'éditeur */
    .documentation-content h1,
    .documentation-content h2,
    .documentation-content h3 {
        color: #2C5F2D; /* Ta couleur verte primaire */
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }

    /* Gestion des images */
    .documentation-content img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin: 1.5rem 0;
    }

    /* Tableaux propres */
    .documentation-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
    }
    .documentation-content td,
    .documentation-content th {
        border: 1px solid #dee2e6;
        padding: 0.75rem;
    }
    .documentation-content th {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="container py-5">

    {{-- 1. En-tête avec Fil d'ariane et Titre --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <span class="badge bg-secondary">{{ $documentation->category->project->nom ?? 'Projet' }}</span>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.categories.show', $documentation->category_id) : route('reader.categories.show', $documentation->category_id) }}" class="text-decoration-none">
                        {{ $documentation->category->nom }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Lecture</li>
            </ol>
        </nav>

        <h1 class="display-5 fw-bold text-dark">{{ $documentation->titre }}</h1>

        <div class="text-muted d-flex gap-3 align-items-center mt-2 flex-wrap">
            <span><i class="bi bi-person-circle"></i> Par {{ $documentation->user->nom ?? 'Auteur' }}</span>
            <span><i class="bi bi-calendar"></i> {{ $documentation->created_at->format('d/m/Y') }}</span>
            <span><i class="bi bi-clock"></i> {{ $documentation->temps_lecture }} min de lecture</span>
            <span><i class="bi bi-eye"></i> {{ $documentation->vues }} vues</span>
        </div>
    </div>

    <div class="row">
        {{-- 2. Contenu Principal --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body p-4 p-lg-5">

                    {{-- Zone d'affichage du contenu --}}
                    <div class="documentation-content lh-lg">
                      {!! $documentation->contenu !!}
                    </div>

                </div>
            </div>
        </div>

        {{-- 3. Barre Latérale (Actions) --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">Actions</div>
                <div class="card-body d-grid gap-2">

                    {{-- Bouton Favoris --}}
                    @if(isset($isFavorite) && $isFavorite)
                        <form action="{{ route('reader.favoris.retirer', $documentation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="favoritable_id" value="{{ $documentation->id }}">
                            <input type="hidden" name="favoritable_type" value="Documentation">
                            <button class="btn btn-outline-danger w-100">
                                <i class="bi bi-heart-fill"></i> Retirer des favoris
                            </button>
                        </form>
                    @else
                        <form action="{{ route('reader.favoris.ajouter') }}" method="POST">
                            @csrf
                            <input type="hidden" name="favoritable_id" value="{{ $documentation->id }}">
                            <input type="hidden" name="favoritable_type" value="Documentation">
                            <button class="btn btn-outline-danger w-100">
                                <i class="bi bi-heart"></i> Ajouter aux favoris
                            </button>
                        </form>
                    @endif

                    {{-- Actions Administrateur --}}
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <hr>
                        <a href="{{ route('admin.documentations.edit', $documentation->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>

                        <form action="{{ route('admin.shared.generate', $documentation->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-info text-white w-100">
                                <i class="bi bi-share"></i> Générer lien partagé
                            </button>
                        </form>

                        <form action="{{ route('admin.documentations.destroy', $documentation->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Liens Partagés --}}
            @if(auth()->check() && auth()->user()->isAdmin() && $documentation->sharedLinks->count() > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-info text-white fw-bold">Liens de partage actifs</div>
                    <ul class="list-group list-group-flush">
                        @foreach($documentation->sharedLinks as $link)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="text-truncate me-2">
                                    <a href="{{ $link->genererLien() }}" target="_blank" class="small">
                                        {{ Str::limit($link->token, 15) }}... <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </div>
                                <span class="badge bg-light text-dark">{{ $link->created_at->format('d/m') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="d-grid">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.documentations.index') : route('reader.documentations.index') }}" class="btn btn-secondary">
                    ↩ Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
