@props(['items' => []])

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        @foreach($items as $item)
            @if(!$loop->last)
                {{-- Élément cliquable --}}
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}" class="text-decoration-none text-primary">
                        {{ $item['label'] }}
                    </a>
                </li>
            @else
                {{-- Élément courant (Actif) --}}
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">
                    {{ $item['label'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
