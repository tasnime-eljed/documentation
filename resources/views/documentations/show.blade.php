@extends('layouts.app')

@section('title', 'Voir documentation')

@section('content')
<div class="container max-w-2xl py-6">

    <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
        📖 {{ $documentation->title }}
    </h2>

    <div class="bg-white p-5 rounded shadow mb-4">
        <p class="text-gray-700 whitespace-pre-line">
            {{ $documentation->content }}
        </p>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('documentation.edit', $documentation->id) }}" class="btn btn-info">
            Modifier
        </a>
        <a href="{{ route('documentation.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>

</div>
@endsection
