@extends('layouts.app')

@section('title', 'Nouvelle Catégorie')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h2 class="h5 mb-0 fw-bold">Ajouter une catégorie</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        {{-- Nom --}}
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-bold">Nom de la catégorie <span class="text-danger">*</span></label>
                            <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Choix du Projet Parent --}}
                        <div class="mb-4">
                            <label for="project_id" class="form-label fw-bold">Projet associé <span class="text-danger">*</span></label>
                            <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un projet --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ (old('project_id') == $project->id || request('project_id') == $project->id) ? 'selected' : '' }}>
                                        {{ $project->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">La catégorie doit appartenir à un projet existant.</div>
                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
