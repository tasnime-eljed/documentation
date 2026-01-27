@extends('admin.app')

@section('title', 'Dashboard Admin - DevDocs')
@section('page-title', 'Dashboard')

@section('styles')
<style>
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
    }

    .stat-icon.projects {
        background: linear-gradient(135deg, #B8A58C 0%, #8B7355 100%);
        box-shadow: 0 6px 20px rgba(184, 165, 140, 0.3);
    }

    .stat-icon.categories {
        background: linear-gradient(135deg, #4A7C4E 0%, #2C5F2D 100%);
        box-shadow: 0 6px 20px rgba(74, 124, 78, 0.3);
    }

    .stat-icon.docs {
        background: linear-gradient(135deg, #D4C5B0 0%, #B8A58C 100%);
        box-shadow: 0 6px 20px rgba(212, 197, 176, 0.3);
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
    }

    .recent-activity {
        list-style: none;
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
    <!-- Statistiques -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-info">
                    <div class="stat-number">{{ $usersCount }}</div>
                    <div class="stat-label">Utilisateurs</div>
                    <span class="stat-change positive">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        </svg>
                        +12%
                    </span>
                </div>
                <div class="stat-icon users">👥</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-info">
                    <div class="stat-number">{{ $projectsCount }}</div>
                    <div class="stat-label">Projets</div>
                    <span class="stat-change positive">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        </svg>
                        +8%
                    </span>
                </div>
                <div class="stat-icon projects">📁</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-info">
                    <div class="stat-number">{{ $categoriesCount }}</div>
                    <div class="stat-label">Catégories</div>
                    <span class="stat-change positive">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        </svg>
                        +5%
                    </span>
                </div>
                <div class="stat-icon categories">📂</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-info">
                    <div class="stat-number">{{ $docsCount }}</div>
                    <div class="stat-label">Documents</div>
                    <span class="stat-change positive">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        </svg>
                        +18%
                    </span>
                </div>
                <div class="stat-icon docs">📄</div>
            </div>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
                Actions Rapides
            </h2>
        </div>
        <div class="quick-actions">
            <a href="{{ route('admin.users.index') }}" class="action-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                Gérer Utilisateurs
            </a>
            <a href="{{ route('admin.projects.create') }}" class="action-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
                Nouveau Projet
            </a>
            <a href="{{ route('admin.categories.create') }}" class="action-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                Nouvelle Catégorie
            </a>
            <a href="{{ route('admin.documentations.create') }}" class="action-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                Nouveau Document
            </a>
        </div>
    </div>

    <!-- Activité Récente -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                Activité Récente
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
                                <span class="activity-target">{{ $activity['target'] }}</span>
                            @endif
                        </div>
                        <div class="activity-time">{{ $activity['time'] }}</div>
                    </div>
                </li>
            @empty
                <li class="activity-item">
                    <div class="activity-icon">ℹ️</div>
                    <div class="activity-content">
                        <div class="activity-action">Aucune activité récente</div>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
@endsection
