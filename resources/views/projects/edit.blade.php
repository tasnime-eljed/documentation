@extends('layouts.app')

@section('title', 'Modifier Projet - DevDocs')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h2 class="h4 mb-0 fw-bold">
                        ✏️ Modifier le projet : {{ $project->nom }}
                    </h2>
                </div>

                <div class="card-body">
                    {{-- Affichage des erreurs --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- CORRECTION 1 : Route admin.projects.update --}}
                    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nom du Projet --}}
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-bold">Nom du projet</label>

                            {{-- CORRECTION 2 : name="nom" et utilisation de old() --}}
                            <input type="text"
                                   name="nom"
                                   id="nom"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   value="{{ old('nom', $project->nom) }}"
                                   required>

                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-warning">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
