@extends('layouts.app')

@section('title', 'Modifier Catégorie - DevDocs')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h2 class="h5 mb-0 fw-bold">✏️ Modifier la catégorie : {{ $category->nom }}</h2>
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

                    {{-- Formulaire de mise à jour --}}
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nom de la catégorie --}}
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-bold">Nom de la catégorie <span class="text-danger">*</span></label>

                            {{-- Utilisation de old() avec la valeur actuelle --}}
                            <input type="text"
                                   name="nom"
                                   id="nom"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   value="{{ old('nom', $category->nom) }}"
                                   required>

                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Choix du Projet Parent --}}
                        <div class="mb-4">
                            <label for="project_id" class="form-label fw-bold">Projet associé <span class="text-danger">*</span></label>
                            <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un projet --</option>
                                {{--
                                    $projects doit être envoyé par le contrôleur (edit method).
                                    Si tu as une erreur "$projects undefined", vérifie ton CategoryController@edit
                                --}}
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ (old('project_id', $category->project_id) == $project->id) ? 'selected' : '' }}>
                                        {{ $project->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Vous pouvez déplacer cette catégorie vers un autre projet.</div>

                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
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
