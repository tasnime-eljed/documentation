@extends('layouts.app')

@section('title', 'Nouvelle Documentation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h2 class="h5 mb-0 fw-bold">
                        📚 Nouvelle documentation
                    </h2>
                </div>

                <div class="card-body">
                    {{-- Affichage des erreurs globales --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.documentations.store') }}" method="POST">
                        @csrf

                        {{-- Titre --}}
                        <div class="mb-3">
                            <label for="titre" class="form-label fw-bold">Titre <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="titre"
                                   id="titre"
                                   class="form-control @error('titre') is-invalid @enderror"
                                   value="{{ old('titre') }}"
                                   required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catégorie (OBLIGATOIRE) --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-bold">Catégorie <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner une catégorie --</option>
                                {{-- $categories doit être envoyé par le contrôleur --}}
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <textarea name="contenu"
                                      id="contenu"
                                      rows="10"
                                      class="form-control @error('contenu') is-invalid @enderror"
                                      placeholder="Écrivez votre documentation ici..."
                                      required>{{ old('contenu') }}</textarea>
                            <div class="form-text">Le format Markdown est supporté.</div>
                            @error('contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.documentations.index') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Enregistrer la documentation
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
