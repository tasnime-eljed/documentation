@extends('layouts.app')

@section('title', 'Modifier documentation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h2 class="h5 mb-0 fw-bold">
                        ✏️ Modifier la documentation : {{ $documentation->titre }}
                    </h2>
                </div>

                <div class="card-body">
                    {{-- Affichage des erreurs --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.documentations.update', $documentation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Titre --}}
                        <div class="mb-3">
                            <label for="titre" class="form-label fw-bold">Titre <span class="text-danger">*</span></label>

                            {{-- CORRECTION : name="titre" et value avec old() --}}
                            <input type="text"
                                   name="titre"
                                   id="titre"
                                   class="form-control @error('titre') is-invalid @enderror"
                                   value="{{ old('titre', $documentation->titre) }}"
                                   required>

                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catégorie (Ajout indispensable) --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-bold">Catégorie <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner une catégorie --</option>
                                {{--
                                    $categories doit être envoyé par le contrôleur.
                                    Si tu as une erreur, vérifie DocumentationController@edit
                                --}}
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (old('category_id', $documentation->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->nom }} (Projet: {{ $category->project->nom ?? '?' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Contenu --}}
                        <div class="mb-4">
                            <label for="contenu" class="form-label fw-bold">Contenu <span class="text-danger">*</span></label>

                            {{-- CORRECTION : name="contenu" --}}
                            <textarea name="contenu"
                                      id="contenu"
                                      rows="10"
                                      class="form-control @error('contenu') is-invalid @enderror"
                                      required>{{ old('contenu', $documentation->contenu) }}</textarea>

                            @error('contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.documentations.index') }}" class="btn btn-outline-secondary">
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
