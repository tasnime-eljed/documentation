@extends('layouts.app')

@section('title', 'Modifier documentation')

@section('content')
<div class="container max-w-xl py-6">

    <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">📚 Modifier documentation</h2>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documentation.update', $documentation->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">Titre</label>
            <input type="text" name="title" value="{{ $documentation->title }}" class="form-input w-full" required>
        </div>

        <div>
            <label class="block font-semibold">Contenu</label>
            <textarea name="content" rows="6" class="form-input w-full" required>{{ $documentation->content }}</textarea>
        </div>

        <div class="flex gap-3">
            <button class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('documentation.index') }}" class="btn btn-secondary">Retour</a>
        </div>

    </form>
</div>
@endsection
