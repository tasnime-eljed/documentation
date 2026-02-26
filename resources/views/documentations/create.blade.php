@extends('layouts.app')

@section('title', 'Nouvelle Documentation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h2 class="h5 mb-0 fw-bold">📚 Nouvelle documentation</h2>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.documentations.store') }}" method="POST">
                        @csrf
                        {{-- Titre --}}
                        <div class="mb-3">
                            <label for="titre" class="form-label fw-bold">Titre <span class="text-danger">*</span></label>
                            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre') }}" required>
                        </div>

                        {{-- Catégorie --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-bold">Catégorie <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">-- Sélectionner une catégorie --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nom }} (Projet: {{ $category->project->nom ?? '?' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Contenu (Transformé par TinyMCE) --}}
                        <div class="mb-4">
                            <label for="contenu" class="form-label fw-bold">Contenu <span class="text-danger">*</span></label>
                            <textarea name="contenu" id="contenu" class="form-control">{{ old('contenu') }}</textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.documentations.index') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT TINYMCE --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#contenu',
        language: 'fr_FR', // Si tu veux l'interface en français (sinon retire cette ligne)
        height: 500,
        menubar: true, // J'ai mis true pour avoir les menus Fichier, Edition, etc. comme Word
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen table help wordcount',
        toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        branding: false,
        // Cette ligne rend l'écriture plus agréable à l'intérieur de l'éditeur
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; line-height:1.6; color:#333; }'
    });
</script>
@endsection
