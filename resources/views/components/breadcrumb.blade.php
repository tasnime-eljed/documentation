@props(['items' => []])

<nav class="mb-4 text-sm text-gray-600">
    <ol class="flex gap-2">
        @foreach($items as $item)
            @if(!$loop->last)
                <li>
                    <a href="{{ $item['url'] }}" class="text-blue-600 hover:underline">
                        {{ $item['label'] }}
                    </a>
                    <span>/</span>
                </li>
            @else
                <li class="font-semibold text-gray-800">
                    {{ $item['label'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
