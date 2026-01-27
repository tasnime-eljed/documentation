@extends('layouts.app')

@section('title', 'Détails Projet - DevDocs')

@section('content')
<div class="container px-4 py-6 max-w-2xl mx-auto">
    <div class="text-2xl font-bold text-var(--primary-dark) mb-4 flex items-center gap-2">
        <span class="text-3xl">📚</span>Projet :
        <span class="text-var(--primary) ml-2">{{ $project->name }}</span>
    </div>

    <div class="bg-white shadow rounded-lg p-5 mb-5">
        <h4 class="font-semibold text-lg text-var(--text-dark)">Description :</h4>
        <p class="text-var(--text-light)">{{ $project->description }}</p>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-info">
            ✏️ Modifier
        </a>

        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
            ↩ Retour
        </a>
    </div>
</div>
@endsection
