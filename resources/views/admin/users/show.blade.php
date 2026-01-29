@extends('layouts.app')

@section('title', 'Profil de ' . $user->nom)

@section('content')
<div class="container py-5">

    {{-- Bouton Retour --}}
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; Retour à la liste
        </a>
    </div>

    <div class="row">
        {{-- Colonne de Gauche : Infos Personnelles --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body p-4">
                    {{-- Grand Avatar --}}
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow mx-auto mb-3"
                         style="width: 100px; height: 100px; font-size: 2.5rem; background: linear-gradient(135deg, var(--primary-dark), var(--primary));">
                        {{ strtoupper(substr($user->nom, 0, 1)) }}
                    </div>

                    <h2 class="h4 fw-bold mb-1">{{ $user->nom }}</h2>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    @if($user->isAdmin())
                        <span class="badge bg-primary fs-6 mb-4">Administrateur</span>
                    @else
                        <span class="badge bg-secondary fs-6 mb-4">Lecteur</span>
                    @endif

                    <div class="border-top pt-3 text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Inscrit le :</small>
                            <small class="fw-bold">{{ $user->created_at->format('d/m/Y') }}</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Dernière activité :</small>
                            <small class="fw-bold">{{ $user->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Colonne de Droite : Activités --}}
        <div class="col-lg-8">

            {{-- Section FAVORIS (Ce que le reader aime) --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold py-3 text-warning">
                    ⭐ Favoris ({{ $user->favorites->count() }})
                </div>
                <div class="list-group list-group-flush">
                    @forelse($user->favorites as $favorite)
                        @php $item = $favorite->favoritable; @endphp
                        @if($item)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    @if($favorite->favoritable_type === 'App\Models\Project')
                                        <span class="badge bg-success me-2">Projet</span>
                                    @elseif($favorite->favoritable_type === 'App\Models\Category')
                                        <span class="badge bg-warning text-dark me-2">Catégorie</span>
                                    @else
                                        <span class="badge bg-info text-dark me-2">Doc</span>
                                    @endif

                                    <span class="fw-bold">{{ $item->nom ?? $item->titre }}</span>
                                </div>
                                <small class="text-muted">{{ $favorite->created_at->format('d/m/Y') }}</small>
                            </div>
                        @endif
                    @empty
                        <div class="list-group-item text-center text-muted py-4">
                            Cet utilisateur n'a ajouté aucun favori.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Section PROJETS CRÉÉS (Visible uniquement si l'user a créé des projets, donc s'il est Admin) --}}
            @if($user->projects->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold py-3 text-success">
                        📂 Projets créés ({{ $user->projects->count() }})
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($user->projects as $project)
                            <a href="{{ route('admin.projects.show', $project->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold text-dark">{{ $project->nom }}</span>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($project->description, 60) }}</small>
                                </div>
                                <span class="badge bg-light text-dark">{{ $project->created_at->format('d/m/Y') }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
