@extends('layouts.app')

@section('title', 'Projets - DevDocs')

@section('content')
<div class="container px-4 py-6">
    <div class="header flex justify-between items-center mb-6">
        <div class="text-2xl font-bold text-var(--primary-dark) flex items-center gap-2">
            <span class="text-3xl">📚</span>Projets
        </div>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            + Nouveau Projet
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
        <div class="card shadow bg-white p-4 rounded-lg border hover:shadow-lg transition">
            <h3 class="text-xl font-semibold text-var(--primary-dark) mb-2">{{ $project->name }}</h3>
            <p class="text-var(--text-light) mb-4">{{ Str::limit($project->description, 80) }}</p>

            <div class="flex justify-between items-center">
                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary text-sm">
                    Voir
                </a>

                <div class="flex gap-2">
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-info text-sm">
                        Modifier
                    </a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Supprimer ce projet ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger text-sm">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center text-var(--text-light)">
            Aucun projet trouvé.
        </div>
        @endforelse
    </div>
</div>
@endsection
