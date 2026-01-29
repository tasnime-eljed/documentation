@extends('layouts.app')

@section('title', 'Catégories - DevDocs')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">
            📂 Gestion des Catégories
        </h1>

        {{-- Bouton Créer (Admin uniquement) --}}
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                + Nouvelle Catégorie
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Nom de la catégorie</th>
                        <th scope="col">Projet associé</th>
                        <th scope="col">Contenu</th>
                        <th scope="col">Date création</th>
                        <th scope="col" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">
                                {{ $category->nom }}
                            </td>
                            <td>
                                @if($category->project)
                                    <span class="badge bg-secondary">
                                        {{ $category->project->nom }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic">Aucun projet</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $category->documentations_count ?? $category->documentations->count() }} docs
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $category->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end pe-4">
                                @php
                                    $showRoute = auth()->user()->isAdmin()
                                        ? route('admin.categories.show', $category->id)
                                        : route('reader.categories.show', $category->id);
                                @endphp

                                <a href="{{ $showRoute }}" class="btn btn-sm btn-outline-primary me-1">
                                    Voir
                                </a>

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-info me-1">
                                        Éditer
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette catégorie ? Toutes les documentations associées seront aussi supprimées.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x display-4 d-block mb-3"></i>
                                Aucune catégorie trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
</div>
@endsection
