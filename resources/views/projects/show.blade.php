@extends('layouts.app')

@section('title', 'Détails Projet - DevDocs')

@section('content')
<div class="container py-5">

    {{-- En-tête du projet --}}
    <div class="bg-light p-4 rounded shadow-sm mb-4 border-start border-5 border-primary">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="display-6 fw-bold text-dark mb-2">
                    <span class="text-primary me-2">📚</span> Projet : {{ $project->nom }}
                </h1>

                <h5 class="mt-3 fw-bold text-secondary">Description :</h5>
                <p class="lead text-muted fs-6 mb-0">
                    {{ $project->description ?? 'Aucune description.' }}
                </p>
            </div>

            {{-- Bouton Modifier (Visible seulement pour Admin) --}}
            @if(auth()->user()->isAdmin())
                <div>
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-outline-info">
                        ✏️ Modifier
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Liste des catégories associées (IMPORTANT) --}}
    <div class="mb-4">
        <h3 class="h5 fw-bold text-secondary mb-3">📂 Catégories du projet</h3>

        <div class="row">
            @forelse($project->categories as $category)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 border-start border-4 border-warning shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $category->nom }}</h5>
                            <p class="card-text small text-muted">
                                {{ $category->documentations->count() }} documentations
                            </p>

                            {{-- Lien vers la catégorie (Admin ou Reader) --}}
                            @php
                                $catRoute = auth()->user()->isAdmin()
                                    ? route('admin.categories.show', $category->id)
                                    : route('reader.categories.show', $category->id);
                            @endphp
                            <a href="{{ $catRoute }}" class="btn btn-sm btn-outline-dark stretched-link">
                                Explorer
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">Aucune catégorie dans ce projet.</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Bouton Retour --}}
    <div>
        @php
            // Calcul de la route retour selon le rôle
            $backRoute = auth()->user()->isAdmin()
                ? route('admin.projects.index')
                : route('reader.projects.index'); // Assure-toi que cette route existe
        @endphp

        <a href="{{ $backRoute }}" class="btn btn-secondary">
            ↩ Retour à la liste
        </a>
    </div>
</div>
@endsection
