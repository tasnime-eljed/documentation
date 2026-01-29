@extends('layouts.app')

@section('title', 'Liste des Documentations')

@section('content')
<div class="container py-5">

    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">
            📚 Bibliothèque de Documentation
        </h1>

        {{-- Bouton Créer (Admin seulement) --}}
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.documentations.create') }}" class="btn btn-primary">
                + Nouvelle documentation
            </a>
        @endif
    </div>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Grille des documents --}}
    <div class="row">
        @forelse($documentations as $doc)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                    <div class="card-body">
                        {{-- Catégorie Badge --}}
                        <div class="mb-2">
                            <span class="badge bg-light text-secondary border">
                                📂 {{ $doc->category->nom ?? 'Sans catégorie' }}
                            </span>
                        </div>

                        {{-- Titre --}}
                        <h5 class="card-title fw-bold text-dark">
                            {{ Str::limit($doc->titre, 40) }}
                        </h5>

                        {{-- Extrait du contenu --}}
                        <p class="card-text text-muted small">
                            {{ Str::limit(strip_tags($doc->contenu), 100) }}
                        </p>

                        {{-- Infos Méta --}}
                        <div class="d-flex justify-content-between text-muted" style="font-size: 0.8rem;">
                            <span><i class="bi bi-eye"></i> {{ $doc->vues }} vues</span>
                            <span><i class="bi bi-clock"></i> {{ $doc->temps_lecture }} min</span>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                        {{-- Route Lire (Dynamique Admin/Reader) --}}
                        @php
                            $readRoute = auth()->user()->isAdmin()
                                ? route('admin.documentations.show', $doc->id)
                                : route('reader.documentations.show', $doc->id);
                        @endphp

                        <a href="{{ $readRoute }}" class="btn btn-sm btn-outline-primary">
                            Lire
                        </a>

                        {{-- Actions Admin --}}
                        @if(auth()->user()->isAdmin())
                            <div class="btn-group">
                                <a href="{{ route('admin.documentations.edit', $doc->id) }}" class="btn btn-sm btn-outline-info">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.documentations.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette documentation ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-0 rounded-end">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <div class="fs-1 mb-3">📄</div>
                    <h4>Aucune documentation trouvée</h4>
                    <p class="text-muted">Commencez par en créer une !</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $documentations->links() }}
    </div>

</div>
@endsection
