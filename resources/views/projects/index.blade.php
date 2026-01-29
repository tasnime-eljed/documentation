@extends('layouts.app')

@section('title', 'Projets - DevDocs')

@section('content')
<div class="container py-5">
    {{-- En-tête : Titre + Bouton Créer (Admin seulement) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">
            📚 Projets
        </h1>

        {{-- Visible uniquement pour l'Admin --}}
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                + Nouveau Projet
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

    {{-- Grille des projets --}}
    <div class="row">
        @forelse($projects as $project)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                    <div class="card-body">
                        {{-- CORRECTION : 'nom' au lieu de 'name' --}}
                        <h5 class="card-title fw-bold text-dark">{{ $project->nom }}</h5>
                        <p class="card-text text-muted small">
                            {{ Str::limit($project->description, 100) }}
                        </p>
                        <p class="text-muted" style="font-size: 0.8rem;">
                            <i class="bi bi-clock"></i> {{ $project->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                        {{-- Calcul de la route 'Show' selon le rôle --}}
                        @php
                            $showRoute = auth()->user()->isAdmin()
                                ? route('admin.projects.show', $project->id)
                                : route('reader.projects.show', $project->id);
                        @endphp

                        <a href="{{ $showRoute }}" class="btn btn-sm btn-outline-primary">
                            Voir
                        </a>

                        {{-- Boutons Admin (Modifier / Supprimer) --}}
                        @if(auth()->user()->isAdmin())
                            <div class="btn-group">
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-outline-info">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce projet ?')">
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
                <div class="alert alert-light text-center border">
                    Aucun projet trouvé pour le moment.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $projects->links() }}
    </div>
</div>
@endsection
