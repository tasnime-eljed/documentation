@extends('layouts.app')

@section('title', $category->nom)

@section('content')
<div class="container py-5">
    {{-- En-tête --}}
    <div class="bg-white p-4 rounded shadow-sm mb-4 border-top border-4 border-warning">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.projects.show', $category->project_id) : route('reader.projects.show', $category->project_id) }}">
                                {{ $category->project->nom }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->nom }}</li>
                    </ol>
                </nav>
                <h1 class="display-6 fw-bold mb-0">{{ $category->nom }}</h1>
            </div>

            @if(auth()->user()->isAdmin())
                <div>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline-secondary">
                        Modifier la catégorie
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Liste des Documentations --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="h5 text-muted">Documentations disponibles</h3>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.documentations.create') }}?category_id={{ $category->id }}" class="btn btn-sm btn-info text-white">
                + Ajouter une documentation
            </a>
        @endif
    </div>

    <div class="row">
        @forelse($category->documentations as $doc)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow transition">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.documentations.show', $doc->id) : route('reader.documentations.show', $doc->id) }}" class="text-decoration-none text-dark">
                                {{ $doc->titre }}
                            </a>
                        </h5>
                        <p class="card-text text-muted small">
                            {{ Str::limit(strip_tags($doc->contenu), 80) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                👁️ {{ $doc->vues }} vues
                            </small>
                            <small class="text-muted">
                                ⏱️ {{ $doc->temps_lecture }} min
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                         <a href="{{ auth()->user()->isAdmin() ? route('admin.documentations.show', $doc->id) : route('reader.documentations.show', $doc->id) }}" class="btn btn-sm btn-primary w-100">
                             Lire
                         </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Aucune documentation dans cette catégorie pour le moment.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
