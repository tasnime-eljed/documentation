@extends('layouts.app')

@section('title', 'Créer documentation')

@section('content')
<div class="container max-w-xl py-6">

    <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">📚 Nouvelle documentation</h2>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documentation.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Titre</label>
            <input type="text" name="title" class="form-input w-full" required>
        </div>

        <div>
            <label class="block font-semibold">Contenu</label>
            <textarea name="content" rows="6" class="form-input w-full" required></textarea>
        </div>

        <div class="flex gap-3">
            <button class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('documentation.index') }}" class="btn btn-secondary">Annuler</a>
        </div>

    </form>
</div>
@endsection
