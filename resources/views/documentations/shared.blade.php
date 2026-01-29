@extends('layouts.guest')

@section('title', $documentation->titre . ' - Document Partagé')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- En-tête du document --}}
            <div class="text-center mb-5">
                <span class="badge bg-warning text-dark mb-2">Document Partagé</span>
                <h1 class="fw-bold display-5 text-dark mb-3">
                    {{ $documentation->titre }}
                </h1>
                <div class="text-muted">
                    <span class="me-3">
                        <i class="bi bi-clock"></i> {{ $documentation->temps_lecture }} min de lecture
                    </span>
                    <span>
                        <i class="bi bi-calendar"></i> Mis à jour {{ $documentation->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            {{-- Contenu du document --}}
            <div class="card shadow-lg border-0">
                <div class="card-body p-4 p-md-5">
                    {{-- Fil d'ariane contextuel --}}
                    <div class="mb-4 pb-3 border-bottom">
                        <small class="text-muted text-uppercase fw-bold" style="letter-spacing: 1px;">
                            {{ $documentation->category->project->nom ?? 'Projet' }}
                            <span class="mx-2">/</span>
                            {{ $documentation->category->nom ?? 'Catégorie' }}
                        </small>
                    </div>

                    {{-- Affichage du contenu --}}
                    <div class="documentation-content lh-lg text-dark">
                        {{--
                           Si tu utilises Markdown, utilise : {!! Str::markdown($documentation->contenu) !!}
                           Sinon, pour du texte brut avec sauts de ligne :
                        --}}
                        {!! nl2br(e($documentation->contenu)) !!}
                    </div>
                </div>
            </div>

            {{-- Pied de page --}}
            <div class="text-center mt-5 text-muted">
                <p>Ce document est partagé via <strong>DevDocs</strong>.</p>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                    Se connecter à la plateforme
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
