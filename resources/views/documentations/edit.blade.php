@extends('layouts.app')

@section('title', 'Modifier documentation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h2 class="h5 mb-0 fw-bold">✏️ Modifier : {{ $documentation->titre }}</h2>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.documentations.update', $documentation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="titre" class="form-label fw-bold">Titre</label>
                            <input type="text" name="titre" class="form-control" value="{{ old('titre', $documentation->titre) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-bold">Catégorie</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $documentation->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="contenu" class="form-label fw-bold">Contenu</label>
                            <textarea name="contenu" id="contenu" class="form-control">{{ old('contenu', $documentation->contenu) }}</textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.documentations.index') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-warning">Mettre à jour</button>
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
        language: 'fr_FR',
        height: 500,
        menubar: true, // Menus activés pour ressembler à Word
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen table help wordcount',
        toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        branding: false,
        // Style interne pour voir le résultat réel pendant l'édition
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; line-height:1.6; color:#333; }'
    });
</script>
@endsection
