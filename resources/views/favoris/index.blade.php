@extends('layouts.app')

@section('title', 'Mes favoris')

@section('content')
<div class="container py-6">

    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        ⭐ Mes documents favoris
    </h2>

    @if($favoris->isEmpty())
        <div class="alert alert-info">
            Aucun document dans vos favoris pour le moment.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($favoris as $favori)
                <div class="card p-4 bg-white shadow rounded">

                    <h3 class="font-semibold text-lg mb-2 flex items-center gap-1">
                        📚 {{ $favori->documentation->title }}
                    </h3>

                    <p class="text-gray-600 mb-3">
                        {{ Str::limit($favori->documentation->content, 80) }}
                    </p>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('documentation.show', $favori->documentation->id) }}"
                           class="btn btn-secondary btn-sm">
                            Lire
                        </a>

                        <form action="{{ route('favoris.destroy', $favori->id) }}" method="POST"
                              onsubmit="return confirm('Retirer ce document des favoris ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                Retirer
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
