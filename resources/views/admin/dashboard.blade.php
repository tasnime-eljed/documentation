@extends('layouts.app') {{-- CORRECTION ICI --}}

@section('title', 'Dashboard Admin - DevDocs')
@section('page-title', 'Tableau de Bord')

@section('styles')
<style>
    /* Ton CSS personnalisé conservé intact pour le design */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(44, 95, 45, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(74, 124, 78, 0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent));
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(74, 124, 78, 0.15);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 18px;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        transition: all 0.3s ease;
    }

    .stat-icon.users {
        background: linear-gradient(135deg, #97B58C 0%, #7FA97F 100%);
        box-shadow: 0 6px 20px rgba(151, 181, 140, 0.3);
        color: white;
    }

    .stat-icon.projects {
        background: linear-gradient(135deg, #B8A58C 0%, #8B7355 100%);
        box-shadow: 0 6px 20px rgba(184, 165, 140, 0.3);
        color: white;
    }

    .stat-icon.categories {
        background: linear-gradient(135deg, #4A7C4E 0%, #2C5F2D 100%);
        box-shadow: 0 6px 20px rgba(74, 124, 78, 0.3);
        color: white;
    }

    .stat-icon.docs {
        background: linear-gradient(135deg, #D4C5B0 0%, #B8A58C 100%);
        box-shadow: 0 6px 20px rgba(212, 197, 176, 0.3);
        color: white;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .stat-info {
        flex: 1;
    }

    .stat-number {
        font-size: 34px;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 6px;
        line-height: 1;
    }

    .stat-label {
        font-size: 14px;
        color: var(--text-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-change {
        font-size: 12px;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 10px;
    }

    .stat-change.positive {
        background: #C6F6D5;
        color: #22543D;
    }

    .content-section {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(44, 95, 45, 0.08);
        margin-bottom: 28px;
        border: 1px solid rgba(74, 124, 78, 0.1);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--background);
    }

    .section-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    .action-btn {
        padding: 18px 22px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 15px rgba(74, 124, 78, 0.25);
        position: relative;
        overflow: hidden;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .action-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .action-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(74, 124, 78, 0.35);
        color: white;
    }

    .recent-activity {
        list-style: none;
        padding-left: 0;
    }

    .activity-item {
        padding: 16px;
        border-left: 3px solid var(--accent);
        background: var(--background);
        border-radius: 10px;
        margin-bottom: 14px;
        transition: all 0.3s ease;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .activity-item:hover {
        background: #E8E5E0;
        transform: translateX(6px);
        box-shadow: 0 4px 12px rgba(74, 124, 78, 0.1);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        background: white;
        box-shadow: 0 2px 8px rgba(74, 124, 78, 0.1);
    }

    .activity-content {
        flex: 1;
    }

    .activity-user {
        font-weight: 700;
        color: var(--primary-dark);
        font-size: 15px;
    }

    .activity-action {
        color: var(--text-light);
        font-size: 14px;
        margin: 4px 0;
    }

    .activity-target {
        font-weight: 600;
        color: var(--text-dark);
    }

    .activity-time {
        color: var(--text-light);
        font-size: 12px;
        font-weight: 600;
    }

    @media (max-width: 968px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }

        .stat-number {
            font-size: 28px;
        }

        .section-header {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Statistiques -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-info">
                    <div class="stat-number">{{ $usersCount }}</div>
                    <div class="stat-label">Utilisateurs</div>
                    <span class="stat-change positive">
                        <i class="bi bi-people-fill"></i> Total
                    </span>
                </div>
                <div class="stat-icon users"><i class="bi bi-people"></i></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-info">
                    <div class="stat-number">{{ $projectsCount }}</div>
                    <div class="stat-label">Projets</div>
                    <span class="stat-change positive">
                        <i class="bi bi-folder-fill"></i> Actifs
                    </span>
                </div>
                <div class="stat-icon projects"><i class="bi bi-folder"></i></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-info">
                    <div class="stat-number">{{ $categoriesCount }}</div>
                    <div class="stat-label">Catégories</div>
                    <span class="stat-change positive">
                        <i class="bi bi-tags-fill"></i> Total
                    </span>
                </div>
                <div class="stat-icon categories"><i class="bi bi-tags"></i></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-info">
                    <div class="stat-number">{{ $docsCount }}</div>
                    <div class="stat-label">Documents</div>
                    <span class="stat-change positive">
                        <i class="bi bi-file-text-fill"></i> Publiés
                    </span>
                </div>
                <div class="stat-icon docs"><i class="bi bi-file-text"></i></div>
            </div>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="bi bi-lightning-charge-fill"></i> Actions Rapides
            </h2>
        </div>
        <div class="quick-actions">
            <a href="{{ route('admin.users.index') }}" class="action-btn">
                <i class="bi bi-people fs-4"></i> Gérer Utilisateurs
            </a>
            <a href="{{ route('admin.projects.create') }}" class="action-btn">
                <i class="bi bi-folder-plus fs-4"></i> Nouveau Projet
            </a>
            <a href="{{ route('admin.categories.create') }}" class="action-btn">
                <i class="bi bi-tag fs-4"></i> Nouvelle Catégorie
            </a>
            <a href="{{ route('admin.documentations.create') }}" class="action-btn">
                <i class="bi bi-file-earmark-plus fs-4"></i> Nouveau Document
            </a>
        </div>
    </div>

    <!-- Activité Récente -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="bi bi-clock-history"></i> Activité Récente
            </h2>
        </div>
        <ul class="recent-activity">
            @forelse($recentActivities as $activity)
                <li class="activity-item">
                    <div class="activity-icon">
                        @if($activity['type'] === 'project')
                            📁
                        @elseif($activity['type'] === 'category')
                            📂
                        @elseif($activity['type'] === 'documentation')
                            📄
                        @else
                            👤
                        @endif
                    </div>
                    <div class="activity-content">
                        <div class="activity-user">{{ $activity['user'] }}</div>
                        <div class="activity-action">
                            {{ $activity['action'] }}
                            @if($activity['target'])
                                <span class="activity-target">"{{ $activity['target'] }}"</span>
                            @endif
                        </div>
                        <div class="activity-time">{{ $activity['time'] }}</div>
                    </div>
                </li>
            @empty
                <li class="activity-item">
                    <div class="activity-icon">ℹ️</div>
                    <div class="activity-content">
                        <div class="activity-action">Aucune activité récente détectée.</div>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
