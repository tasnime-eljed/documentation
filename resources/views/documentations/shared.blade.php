@extends('layouts.guest')

@section('title', 'Documentation partagée')

@section('content')
<div class="container max-w-2xl py-6">

    <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
        📚 {{ $documentation->title }}
    </h2>

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-700 whitespace-pre-line">
            {{ $documentation->content }}
        </p>
    </div>

</div>
@endsection
