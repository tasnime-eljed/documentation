@extends('layouts.app')

@section('title', 'Mes Favoris - DevDocs')

@section('content')
<div class="container py-5">

    <div class="d-flex align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">
            ⭐ Mes Favoris
        </h1>
    </div>

    @if($favoris->isEmpty())
        <div class="alert alert-info text-center py-5">
            <div class="fs-1 mb-3">📭</div>
            <h4>Votre liste de favoris est vide.</h4>
            <p class="text-muted">Ajoutez des projets ou des documentations à vos favoris pour les retrouver ici.</p>
            <a href="{{ route('reader.dashboard') }}" class="btn btn-primary mt-2">Retour au Dashboard</a>
        </div>
    @else
        <div class="row">
            @foreach($favoris as $favori)
                @php
                    // Récupération de l'objet réel (Project, Category, Documentation)
                    $item = $favori->favoritable;
                    $type = $favori->favoritable_type;
                @endphp

                {{-- Si l'objet a été supprimé entre temps, on ne l'affiche pas --}}
                @if($item)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                            <div class="card-header bg-white border-bottom-0 pt-3 d-flex justify-content-between align-items-start">
                                {{-- Badge selon le type --}}
                                @if($type === 'App\Models\Project')
                                    <span class="badge bg-success">Projet</span>
                                @elseif($type === 'App\Models\Category')
                                    <span class="badge bg-warning text-dark">Catégorie</span>
                                @elseif($type === 'App\Models\Documentation')
                                    <span class="badge bg-info text-dark">Documentation</span>
                                @endif

                                <small class="text-muted">Ajouté {{ $favori->created_at->diffForHumans() }}</small>
                            </div>

                            <div class="card-body">
                                {{-- Titre (Nom pour Projet/Cat, Titre pour Doc) --}}
                                <h5 class="card-title fw-bold">
                                    {{ $item->nom ?? $item->titre }}
                                </h5>

                                {{-- Description / Contenu --}}
                                <p class="card-text text-muted small">
                                    @if(isset($item->description))
                                        {{ Str::limit($item->description, 80) }}
                                    @elseif(isset($item->contenu))
                                        {{ Str::limit(strip_tags($item->contenu), 80) }}
                                    @endif
                                </p>
                            </div>

                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                                {{-- Bouton Lire --}}
                                @php
                                    $route = '#';
                                    if($type === 'App\Models\Project') $route = route('reader.projects.show', $item->id);
                                    elseif($type === 'App\Models\Category') $route = route('reader.categories.show', $item->id);
                                    elseif($type === 'App\Models\Documentation') $route = route('reader.documentations.show', $item->id);
                                @endphp

                                <a href="{{ $route }}" class="btn btn-sm btn-outline-primary">
                                    Accéder
                                </a>

                                {{-- Bouton Retirer --}}
                                <form action="{{ route('reader.favoris.retirer', $item->id) }}" method="POST" onsubmit="return confirm('Retirer des favoris ?')">
                                    @csrf
                                    @method('DELETE')
                                    {{-- On passe les infos nécessaires pour que le contrôleur s'y retrouve --}}
                                    <input type="hidden" name="favoritable_id" value="{{ $item->id }}">
                                    <input type="hidden" name="favoritable_type" value="{{ class_basename($type) }}">

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Retirer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
