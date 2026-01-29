@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container py-5">

    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">
            👥 Gestion des Utilisateurs
        </h1>
        <span class="badge bg-white text-dark border shadow-sm p-2">
            Total : {{ $users->total() }} inscrits
        </span>
    </div>

    {{-- Tableau des utilisateurs --}}
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Utilisateur</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rôle</th>
                        <th scope="col">Inscrit le</th>
                        <th scope="col" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    {{-- Avatar avec Initiale --}}
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm"
                                         style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--accent));">
                                        {{ strtoupper(substr($user->nom, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $user->nom }}</span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="badge bg-primary">Administrateur</span>
                                @else
                                    <span class="badge bg-secondary">Lecteur</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Profil
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
