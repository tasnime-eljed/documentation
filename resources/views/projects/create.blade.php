@extends('layouts.app')

@section('title', 'Créer Projet - DevDocs')

@section('content')
<div class="container px-4 py-6 max-w-xl mx-auto">
    <div class="text-2xl font-bold text-var(--primary-dark) mb-4 flex items-center gap-2">
        <span class="text-3xl">📚</span>Créer un nouveau projet
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold text-var(--text-dark)">Nom du projet</label>
            <input type="text" name="name" class="form-input w-full" required>
        </div>

        <div>
            <label class="block font-semibold text-var(--text-dark)">Description</label>
            <textarea name="description" class="form-input w-full" rows="4"></textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
