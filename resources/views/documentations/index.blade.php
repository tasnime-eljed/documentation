@extends('layouts.app')

@section('title', 'Documentation')

@section('content')
<div class="container py-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">📚 Documentation</h2>
        <a href="{{ route('documentation.create') }}" class="btn btn-primary">
            + Nouvelle documentation
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($documentations as $doc)
            <div class="card p-4 shadow rounded bg-white">
                <h3 class="font-semibold text-lg mb-2">{{ $doc->title }}</h3>
                <p class="text-gray-600 mb-3">{{ Str::limit($doc->content, 80) }}</p>

                <div class="flex justify-between items-center">
                    <a href="{{ route('documentation.show', $doc->id) }}" class="btn btn-secondary btn-sm">
                        Lire
                    </a>

                    <div class="flex gap-2">
                        <a href="{{ route('documentation.edit', $doc->id) }}" class="btn btn-info btn-sm">
                            Modifier
                        </a>

                        <form action="{{ route('documentation.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Supprimer cette documentation ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
