@extends('layouts.app')

@section('title', $documentation->titre)

@section('content')
<div class="container py-5">

    {{-- 1. En-tête avec Fil d'ariane et Titre --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <span class="badge bg-secondary">{{ $documentation->category->project->nom }}</span>
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
            <span><i class="bi bi-person-circle"></i> Par {{ $documentation->user->nom }}</span>
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
                    <div class="documentation-content lh-lg">
                        {{-- Affichage propre du contenu (avec sauts de ligne) --}}
                        {!! nl2br(e($documentation->contenu)) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Barre Latérale (Actions) --}}
        <div class="col-lg-4">
            {{-- Carte Actions --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">Actions</div>
                <div class="card-body d-grid gap-2">

                    {{-- Bouton Favoris (Pour tout le monde) --}}
                    @if($isFavorite)
                        <form action="{{ route('reader.favoris.retirer', $documentation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            {{-- Pour le polymorphisme, on spécifie les champs cachés si nécessaire,
                                 mais ici ta route "retirer" prend l'ID direct --}}
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
                    @if(auth()->user()->isAdmin())
                        <hr>
                        <a href="{{ route('admin.documentations.edit', $documentation->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>

                        {{-- Générer Lien Partagé --}}
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

            {{-- Carte Liens Partagés (Visible si Admin et s'il y a des liens) --}}
            @if(auth()->user()->isAdmin() && $documentation->sharedLinks->count() > 0)
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

            {{-- Bouton Retour --}}
            <div class="d-grid">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.documentations.index') : route('reader.documentations.index') }}" class="btn btn-secondary">
                    ↩ Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
