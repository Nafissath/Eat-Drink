@extends('layouts.admin')

@section('content')
    <div class="luxury-dashboard">
        <!-- Header Page -->
        <div class="header-premium mb-5 animate-fade-in">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="premium-title">
                        <span class="text-gold"><i class="fas fa-trophy me-3"></i></span>
                        Maîtrise du <span class="text-gold">Défi Elite Gold</span>
                    </h1>
                    <p class="premium-subtitle">Gestion stratégique des joueurs et des récompenses</p>
                </div>
                <div class="col-auto">
                    <div class="btn-group-luxury">
                        <button class="btn-luxury-action" onclick="window.location.reload()">
                            <i class="fas fa-sync-alt me-2"></i> Actualiser
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn-luxury-action secondary">
                            <i class="fas fa-arrow-left me-2"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="row g-4 mb-5 animate-fade-up">
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-gold-gradient">
                        <i class="fas fa-gem"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">PÉPITES TOTALES</p>
                        <h2 class="stat-value">{{ number_format($stats['total_pepites'], 0) }}</h2>
                    </div>
                    <div class="stat-glow gold"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card border-gold-glow">
                    <div class="stat-icon-box bg-gold-luxury">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">RANGS OR</p>
                        <h2 class="stat-value text-gold">{{ $stats['count_or'] }}</h2>
                    </div>
                    <div class="stat-glow gold"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-silver-luxury">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">RANGS ARGENT</p>
                        <h2 class="stat-value text-silver">{{ $stats['count_argent'] }}</h2>
                    </div>
                    <div class="stat-glow silver"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-bronze-luxury">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">RANGS BRONZE</p>
                        <h2 class="stat-value text-bronze">{{ $stats['count_bronze'] }}</h2>
                    </div>
                    <div class="stat-glow bronze"></div>
                </div>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="glass-card-luxury mb-5 p-4 animate-fade-up">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="luxury-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="playerSearch" class="luxury-input"
                            placeholder="Rechercher un joueur (Nom, Email)..." onkeyup="filterPlayers()">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="rankFilter" class="luxury-select" onchange="filterPlayers()">
                        <option value="all">Tous les Rangs</option>
                        <option value="Or">Rang Or</option>
                        <option value="Argent">Rang Argent</option>
                        <option value="Bronze">Rang Bronze</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge-luxury" id="totalCount">{{ $pendingPlayers->count() + $approvedPlayers->count() }}
                        JOUEURS IDENTIFIÉS</span>
                </div>
            </div>
        </div>

        @if(session('status'))
            <div class="alert bg-emerald border-0 text-white rounded-4 mb-4 p-3 animate-fade-in shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            </div>
        @endif

        <!-- Tabs Navigation -->
        <ul class="nav nav-pills luxury-tabs mb-4 animate-fade-up" id="playerTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending"
                    type="button" role="tab">
                    <i class="fas fa-hourglass-start me-2"></i>En attente
                    <span class="badge bg-gold-luxury ms-2 text-dark">{{ $pendingPlayers->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="pill" data-bs-target="#approved" type="button"
                    role="tab">
                    <i class="fas fa-users-check me-2"></i>Joueurs Actifs
                    <span class="badge bg-white-10 ms-2">{{ $approvedPlayers->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="pill" data-bs-target="#rejected" type="button"
                    role="tab">
                    <i class="fas fa-user-slash me-2"></i>Rejetés
                    <span class="badge bg-white-10 ms-2">{{ $rejectedPlayers->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="playerTabsContent">
            <!-- Pending Tab -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <div class="glass-card-luxury p-0 overflow-hidden animate-fade-up">
                    <div class="luxury-table-container">
                        @if($pendingPlayers->isEmpty())
                            <div class="empty-state-luxury text-center py-5">
                                <div class="empty-icon-box mb-4">
                                    <i class="fas fa-check-double text-emerald"></i>
                                </div>
                                <h4>Sérénité Absolue</h4>
                                <p class="text-white-50">Toutes les candidatures ont été traitées.</p>
                            </div>
                        @else
                            <table class="luxury-table" id="tablePending">
                                <thead>
                                    <tr>
                                        <th>JOUEUR</th>
                                        <th>EMAIL</th>
                                        <th>INSCRIPTION</th>
                                        <th class="text-end">DÉCISION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingPlayers as $player)
                                        <tr class="luxury-row player-row" data-name="{{ strtolower($player->nom_entreprise) }}"
                                            data-email="{{ strtolower($player->email) }}" data-rank="all">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-luxury">
                                                        <i class="fas fa-user-ninja"></i>
                                                    </div>
                                                    <div>
                                                        <div class="row-main-text text-white">{{ $player->nom_entreprise }}</div>
                                                        <div class="row-sub-text">Candidat Joueur #{{ $player->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="text-white-50 small">{{ $player->email }}</span></td>
                                            <td>
                                                <div class="row-main-text">{{ $player->created_at->format('d/m/Y') }}</div>
                                                <div class="row-sub-text">{{ $player->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td class="text-end">
                                                <div class="action-stack">
                                                    <form action="{{ route('admin.joueurs.valider', $player->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action-luxury success"
                                                            title="Approuver le Joueur">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.joueurs.rejeter', $player->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action-luxury danger"
                                                            title="Rejeter le Joueur">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Approved Tab -->
            <div class="tab-pane fade" id="approved" role="tabpanel">
                <div class="glass-card-luxury p-0 overflow-hidden animate-fade-up">
                    <div class="luxury-table-container">
                        <table class="luxury-table" id="tableApproved">
                            <thead>
                                <tr>
                                    <th>JOUEUR</th>
                                    <th>CAPITAL PÉPITES</th>
                                    <th>PALIER / RANG</th>
                                    <th class="text-end">STATUT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approvedPlayers as $player)
                                    <tr class="luxury-row player-row" data-name="{{ strtolower($player->nom_entreprise) }}"
                                        data-email="{{ strtolower($player->email) }}" data-rank="{{ $player->rang }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-luxury" style="background: rgba(255,255,255,0.05);">
                                                    {{ strtoupper(substr($player->nom_entreprise, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="row-main-text">{{ $player->nom_entreprise }}</div>
                                                    <div class="row-sub-text">{{ $player->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gold fw-800 fs-5 me-2">{{ number_format($player->pepites, 0) }}</span>
                                                <i class="fas fa-gem text-gold small"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded-pill px-3 py-1 fw-700 {{ $player->rang === 'Or' ? 'bg-gold-luxury' : ($player->rang === 'Argent' ? 'bg-silver-luxury' : 'bg-bronze-luxury') }}">
                                                <i
                                                    class="fas {{ $player->rang === 'Or' ? 'fa-crown' : ($player->rang === 'Argent' ? 'fa-medal' : 'fa-award') }} me-1"></i>
                                                {{ $player->rang }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-emerald-light text-emerald px-3 py-1 border-emerald-subtle">
                                                <i class="fas fa-circle small me-1"></i> ACTIF
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rejected Tab -->
            <div class="tab-pane fade" id="rejected" role="tabpanel">
                <div class="glass-card-luxury p-0 overflow-hidden animate-fade-up">
                    <div class="luxury-table-container">
                        @if($rejectedPlayers->isEmpty())
                            <div class="empty-state-luxury text-center py-5">
                                <i class="fas fa-user-slash text-white-10 fs-1 mb-4"></i>
                                <p class="text-white-50">Aucun joueur n'a été banni ou rejeté.</p>
                            </div>
                        @else
                            <table class="luxury-table" id="tableRejected">
                                <thead>
                                    <tr>
                                        <th>UTILISATEUR</th>
                                        <th>EMAIL</th>
                                        <th>DATE REJET</th>
                                        <th class="text-end">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rejectedPlayers as $player)
                                        <tr class="luxury-row player-row" data-name="{{ strtolower($player->nom_entreprise) }}"
                                            data-email="{{ strtolower($player->email) }}" data-rank="all">
                                            <td>
                                                <span class="row-main-text text-white-50">{{ $player->nom_entreprise }}</span>
                                            </td>
                                            <td><span class="text-white-50">{{ $player->email }}</span></td>
                                            <td><span class="text-danger-light">{{ $player->updated_at->format('d/m/Y') }}</span>
                                            </td>
                                            <td class="text-end">
                                                <form action="{{ route('admin.joueurs.valider', $player->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-3">
                                                        RÉHABILITER
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Tabs Styling */
        .luxury-tabs {
            background: rgba(255, 255, 255, 0.03);
            padding: 8px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .luxury-tabs .nav-link {
            color: rgba(255, 255, 255, 0.5);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .luxury-tabs .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .luxury-tabs .nav-link.active {
            background: var(--luxury-gold) !important;
            color: #0f172a !important;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        }

        .bg-emerald {
            background-color: #10b981 !important;
        }

        .bg-emerald-light {
            background-color: rgba(16, 185, 129, 0.05) !important;
        }

        .text-emerald {
            color: #10b981 !important;
        }

        .border-emerald-subtle {
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .bg-white-10 {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .text-danger-light {
            color: #fca5a5;
        }

        .text-silver {
            color: #e2e8f0;
        }

        .text-bronze {
            color: #cd7f32;
        }

        .bg-gold-luxury {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #0f172a;
        }

        .bg-silver-luxury {
            background: linear-gradient(135deg, #9ca3af 0%, #4b5563 100%);
            color: white;
        }

        .bg-bronze-luxury {
            background: linear-gradient(135deg, #cd7f32 0%, #8b4513 100%);
            color: white;
        }

        .stat-glow.silver {
            background: #9ca3af;
        }

        .stat-glow.bronze {
            background: #cd7f32;
        }

        .badge-luxury {
            background: rgba(212, 175, 55, 0.1);
            color: var(--luxury-gold);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.7rem;
            letter-spacing: 1px;
        }
    </style>

    @push('scripts')
        <script>
            function filterPlayers() {
                const query = document.getElementById('playerSearch').value.toLowerCase();
                const rank = document.getElementById('rankFilter').value;
                const rows = document.querySelectorAll('.player-row');
                let visibleCount = 0;

                rows.forEach(row => {
                    const name = row.getAttribute('data-name');
                    const email = row.getAttribute('data-email');
                    const playerRank = row.getAttribute('data-rank');

                    const matchesSearch = name.includes(query) || email.includes(query);
                    const matchesRank = rank === 'all' || playerRank === rank;

                    if (matchesSearch && matchesRank) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Feedback count might be misleading because of tabs, but we update the identified count anyway
                // document.getElementById('totalCount').textContent = visibleCount + ' JOUEURS CORRESPONDENT';
            }
        </script>
    @endpush
@endsection