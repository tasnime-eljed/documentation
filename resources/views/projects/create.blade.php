@extends('layouts.app')

@section('title', 'Créer Projet - DevDocs')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="h4 mb-0 fw-bold text-primary">
                        📚 Créer un nouveau projet
                    </h2>
                </div>

                <div class="card-body">
                    {{-- Affichage des erreurs de validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- CORRECTION 1 : La route correcte est 'admin.projects.store' --}}
                    <form action="{{ route('admin.projects.store') }}" method="POST">
                        @csrf

                        {{-- Nom du Projet --}}
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-bold">Nom du projet <span class="text-danger">*</span></label>

                            {{-- CORRECTION 2 : name="nom" pour correspondre à ta base de données --}}
                            <input type="text"
                                   name="nom"
                                   id="nom"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   value="{{ old('nom') }}"
                                   placeholder="Ex: Documentation API v1"
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
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Description courte du projet...">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-flex gap-2 justify-content-end">
                            {{-- CORRECTION 3 : Lien d'annulation vers la liste admin --}}
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Enregistrer le projet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
