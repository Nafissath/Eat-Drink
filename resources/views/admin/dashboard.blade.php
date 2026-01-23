@extends('layouts.admin')

@section('content')
    <div class="luxury-dashboard">
        <!-- Header Page -->
        <div class="header-premium mb-5 animate-fade-in">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="premium-title">
                        <span class="text-gold"><i class="fas fa-crown me-3"></i></span>
                        Tableau de Bord <span class="text-gold">Admin</span>
                    </h1>
                    <p class="premium-subtitle">Gestion exclusive des partenaires Eat&Drink</p>
                </div>
                <div class="col-auto">
                    <div class="btn-group-luxury">
                        <button class="btn-luxury-action" onclick="refreshData()">
                            <i class="fas fa-sync-alt me-2"></i> Actualiser
                        </button>
                        <button class="btn-luxury-action secondary" onclick="exportData()">
                            <i class="fas fa-file-export me-2"></i> Exporter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if($pendingPlayersCount > 0)
            <div class="alert bg-gold-luxury border-0 text-dark rounded-4 mb-5 p-4 animate-fade-in shadow-lg">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-dark rounded-circle p-3 text-gold">
                            <i class="fas fa-trophy fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-800">Nouveaux Joueurs pour le Défi Elite Gold</h5>
                            <p class="mb-0 opacity-75">Il y a <strong>{{ $pendingPlayersCount }}</strong> candidatures de
                                joueurs en attente de validation.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.joueurs.index') }}" class="btn btn-dark rounded-pill px-4 fw-700">
                        VOIR LES JOUEURS <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        @endif

        <!-- Quick Stats Grid -->
        <div class="row g-4 mb-5 animate-fade-up">
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-gold-gradient">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">DEMANDES EN ATTENTE</p>
                        <h2 class="stat-value" id="pendingCount">{{ $demandes->count() }}</h2>
                    </div>
                    <div class="stat-glow gold"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-emerald-gradient">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">PARTENAIRES ACTIFS</p>
                        <h2 class="stat-value" id="totalApproved">0</h2>
                    </div>
                    <div class="stat-glow emerald"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-blue-gradient">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">APPROUVÉS AUJOURD'HUI</p>
                        <h2 class="stat-value" id="approvedToday">-</h2>
                    </div>
                    <div class="stat-glow blue"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('admin.joueurs.index') }}" class="text-decoration-none">
                    <div class="glass-stat-card border-gold-glow">
                        <div class="stat-icon-box bg-gold-luxury">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">JOUEURS EN ATTENTE</p>
                            <h2 class="stat-value text-gold">{{ $pendingPlayersCount }}</h2>
                        </div>
                        <div class="stat-glow gold"></div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="glass-card-luxury mb-5 p-4 animate-fade-up" style="animation-delay: 0.1s;">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-sliders-h text-gold me-3 fs-4"></i>
                <h5 class="mb-0 fw-bold">Raffinement de la Recherche</h5>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="premium-label">RECHERCHER</label>
                    <div class="luxury-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" class="luxury-input" placeholder="Email ou établissement...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="premium-label">TRIER PAR</label>
                    <select id="sortSelect" class="luxury-select">
                        <option value="date_desc">Date (Récente)</option>
                        <option value="date_asc">Date (Ancienne)</option>
                        <option value="entreprise_asc">Établissement A-Z</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="premium-label">FILTRE STATUT</label>
                    <select id="statusFilter" class="luxury-select">
                        <option value="all">Tout Afficher</option>
                        <option value="new">Nouvelles Demandes</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn-premium-search w-100" onclick="applyFilters()">
                        FILTRER <i class="fas fa-filter ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Table -->
        <div class="glass-card-luxury p-0 overflow-hidden animate-fade-up" style="animation-delay: 0.2s;">
            <div class="card-header-luxury d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list-check text-gold me-3"></i>
                    <h5 class="mb-0 fw-bold">Demandes Premium en Attente</h5>
                </div>
                <span class="badge-luxury" id="pendingBadge">{{ $demandes->count() }} CANDIDATURES</span>
            </div>

            <div class="luxury-table-container">
                @if($demandes->isEmpty())
                    <div class="empty-state-luxury text-center py-5">
                        <div class="empty-icon-box mb-4">
                            <i class="fas fa-check-double text-emerald"></i>
                        </div>
                        <h4>Excellence Atteinte</h4>
                        <p class="text-white-50">Toutes les demandes ont été traitées avec succès.</p>
                    </div>
                @else
                    <table class="luxury-table">
                        <thead>
                            <tr>
                                <th class="text-center" width="60">
                                    <div class="luxury-checkbox-wrapper">
                                        <input type="checkbox" id="selectAll" class="luxury-checkbox">
                                    </div>
                                </th>
                                <th>PARTENAIRE</th>
                                <th>ÉTABLISSEMENT</th>
                                <th>TEMPS D'ATTENTE</th>
                                <th class="text-end">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="demandesTbody">
                            @foreach($demandes as $user)
                                <tr class="luxury-row animate-row" data-id="{{ $user->id }}">
                                    <td class="text-center">
                                        <div class="luxury-checkbox-wrapper">
                                            <input type="checkbox" class="luxury-checkbox demande-checkbox" value="{{ $user->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-luxury">
                                                {{ strtoupper(substr($user->email, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="row-main-text">{{ $user->email }}</div>
                                                <div class="row-sub-text">Candidat #{{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-gold fw-bold">{{ $user->nom_entreprise }}</div>
                                        <div class="row-sub-text">Entrepreneur Gastronomique</div>
                                    </td>
                                    <td>
                                        @php
                                            $waitTime = $user->created_at->diff(now());
                                            $waitHours = $waitTime->h + ($waitTime->days * 24);
                                        @endphp
                                        <div
                                            class="wait-badge-luxury {{ $waitHours > 24 ? 'urgent' : ($waitHours > 12 ? 'warning' : 'optimal') }}">
                                            <i class="far fa-clock me-1"></i> {{ $waitHours }}h d'attente
                                        </div>
                                        <div class="row-sub-text mt-1">Depuis le {{ $user->created_at->format('d/m H:i') }}</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-stack">
                                            <button class="btn-action-luxury success" title="Approuver"
                                                onclick="approveUser('{{ $user->id }}')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn-action-luxury danger" title="Rejeter"
                                                onclick="showRejectModal('{{ $user->id }}')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button class="btn-action-luxury info" title="Détails"
                                                onclick="viewDetails('{{ $user->id }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Bulk Actions Overlay -->
        <div id="bulkActions" class="bulk-actions-floating animate-slide-up" style="display: none;">
            <div class="d-flex align-items-center gap-4">
                <p class="mb-0 fw-bold"><span id="selectedCount" class="text-gold">0</span> éléments sélectionnés</p>
                <div class="h-divider"></div>
                <button class="btn-bulk approve" onclick="bulkApprove()">
                    APPROUVER LA SÉLECTION <i class="fas fa-check-circle ms-2"></i>
                </button>
                <button class="btn-bulk reject" onclick="bulkReject()">
                    REJETER TOUT <i class="fas fa-times-circle ms-2"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Reject Premium -->
    <div class="modal fade luxury-modal" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-card-luxury">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">DÉCISION DE <span class="text-gold">REJET</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-white-50 mb-4">Veuillez spécifier la raison de cette décision exclusive.</p>
                    <form id="rejectForm">
                        <input type="hidden" id="rejectUserId" name="user_id">
                        <div class="mb-3">
                            <textarea class="luxury-textarea" id="motifRejet" rows="4"
                                placeholder="Expliquez les raisons du rejet avec prestige..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-luxury-outline sm" data-bs-dismiss="modal">ANNULER</button>
                    <button type="button" class="btn-luxury-primary sm danger" onclick="confirmReject()">
                        CONFIRMER LE REJET
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Premium Styling Tokens */
        .luxury-dashboard {
            max-width: 1400px;
            margin: 0 auto;
        }

        .premium-title {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 2.5rem;
        }

        .premium-subtitle {
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Stat Cards */
        .glass-stat-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            height: 100%;
            transition: all 0.3s ease;
        }

        .glass-stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .stat-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1.5rem;
            z-index: 2;
        }

        .stat-content {
            z-index: 2;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-weight: 800;
            margin-bottom: 0;
            font-size: 2rem;
        }

        /* Gradients */
        .bg-gold-gradient {
            background: linear-gradient(135deg, #d4af37, #b8860b);
            color: white;
        }

        .bg-emerald-gradient {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .bg-blue-gradient {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .bg-stopwatch-gradient {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
            color: white;
        }

        .stat-glow {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            filter: blur(50px);
            opacity: 0.15;
            right: -30px;
            top: -30px;
            z-index: 1;
        }

        .stat-glow.gold {
            background: #d4af37;
        }

        .stat-glow.emerald {
            background: #10b981;
        }

        .stat-glow.blue {
            background: #3b82f6;
        }

        .stat-glow.purple {
            background: #8b5cf6;
        }

        /* Buttons Actions */
        .btn-group-luxury {
            display: flex;
            gap: 1rem;
        }

        .btn-luxury-action {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-luxury-action:hover {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
            border-color: var(--luxury-gold);
            transform: translateY(-2px);
        }

        .btn-luxury-action.secondary:hover {
            background: white;
            color: black;
            border-color: white;
        }

        /* Luxury Table */
        .glass-card-luxury {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .card-header-luxury {
            padding: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .luxury-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .luxury-table th {
            padding: 1.5rem 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.02);
        }

        .luxury-row {
            transition: all 0.3s ease;
        }

        .luxury-row:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .luxury-row td {
            padding: 1.5rem 2rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .avatar-luxury {
            width: 45px;
            height: 45px;
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--luxury-gold);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            margin-right: 1.25rem;
        }

        .row-main-text {
            font-weight: 700;
            font-size: 1rem;
            color: white;
        }

        .row-sub-text {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .wait-badge-luxury {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .wait-badge-luxury.optimal {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .wait-badge-luxury.warning {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .wait-badge-luxury.urgent {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* Action Buttons */
        .action-stack {
            display: flex;
            gap: 0.6rem;
            justify-content: flex-end;
        }

        .btn-action-luxury {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.03);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-action-luxury:hover {
            transform: scale(1.15) translateY(-3px);
        }

        .btn-action-luxury.success:hover {
            background: #10b981;
            border-color: #10b981;
            color: white;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-action-luxury.danger:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }

        .btn-action-luxury.info:hover {
            background: #3b82f6;
            border-color: #3b82f6;
            color: white;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        /* Inputs & Selects */
        .premium-label {
            font-size: 0.65rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 0.5rem;
            display: block;
            letter-spacing: 0.1em;
        }

        .luxury-input-wrapper {
            position: relative;
            width: 100%;
        }

        .luxury-input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.2);
        }

        .luxury-input,
        .luxury-select,
        .luxury-textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .luxury-input {
            padding-left: 2.5rem;
        }

        .luxury-input:focus,
        .luxury-select:focus,
        .luxury-textarea:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--luxury-gold);
            outline: none;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        .btn-premium-search {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            border: 1px solid var(--luxury-gold);
            padding: 0.75rem;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
        }

        .btn-premium-search:hover {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
            transform: scale(1.02);
        }

        /* Checkbox Premium */
        .luxury-checkbox {
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            appearance: none;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .luxury-checkbox:checked {
            background: var(--luxury-gold);
            border-color: var(--luxury-gold);
        }

        .luxury-checkbox:checked:after {
            content: '✓';
            position: absolute;
            color: var(--luxury-dark);
            font-weight: 900;
            font-size: 14px;
            left: 4px;
            top: -1px;
        }

        /* Floating Bulk Actions */
        .bulk-actions-floating {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid var(--luxury-gold);
            padding: 1rem 2rem;
            border-radius: 50px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .btn-bulk {
            padding: 0.6rem 1.5rem;
            border-radius: 30px;
            background: transparent;
            border: 1px solid white;
            color: white;
            font-weight: 800;
            font-size: 0.8rem;
            transition: all 0.3s;
        }

        .btn-bulk.approve {
            background: var(--luxury-gold);
            border-color: var(--luxury-gold);
            color: var(--luxury-dark);
        }

        .btn-bulk:hover {
            transform: scale(1.05);
        }

        .h-divider {
            width: 1px;
            height: 30px;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Badges */
        .badge-luxury {
            background: rgba(212, 175, 55, 0.15);
            color: var(--luxury-gold);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 0.4rem 1rem;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.1em;
        }

        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease-out backwards;
        }

        .animate-slide-up {
            animation: slideUp 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translate(-50%, 50px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }
    </style>

    @push('scripts')
        <script>
            // Variables globales
            let selectedDemandes = new Set();

            // Initialisation
            document.addEventListener('DOMContentLoaded', function () {
                setupEventListeners();
                fetchStats();
                setInterval(fetchStats, 10000);
                setInterval(refreshData, 30000);
            });

            function setupEventListeners() {
                // Sélection globale
                const selectAll = document.getElementById('selectAll');
                if (selectAll) {
                    selectAll.addEventListener('change', function () {
                        const checkboxes = document.querySelectorAll('.demande-checkbox');
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                            if (this.checked) selectedDemandes.add(checkbox.value);
                            else selectedDemandes.delete(checkbox.value);
                        });
                        updateBulkActions();
                    });
                }

                // Sélection individuelle
                document.body.addEventListener('change', function (e) {
                    if (e.target.classList.contains('demande-checkbox')) {
                        const checkbox = e.target;
                        if (checkbox.checked) selectedDemandes.add(checkbox.value);
                        else selectedDemandes.delete(checkbox.value);
                        updateBulkActions();
                    }
                });
            }

            function updateBulkActions() {
                const bulkDiv = document.getElementById('bulkActions');
                const countSpan = document.getElementById('selectedCount');
                if (selectedDemandes.size > 0) {
                    bulkDiv.style.display = 'block';
                    countSpan.textContent = selectedDemandes.size;
                } else {
                    bulkDiv.style.display = 'none';
                }
            }

            async function fetchStats() {
                try {
                    const response = await fetch('/dashboard/statistiques-data?t=' + Date.now());
                    if (response.ok) {
                        const data = await response.json();
                        if (data.stats) {
                            updateStatValue('totalApproved', data.stats.entrepreneurs_approuves);
                            updateStatValue('approvedToday', data.stats.approuves_aujourdhui || 0);
                            // On pourrait ajouter d'autres stats ici
                        }
                    }
                } catch (e) { console.error("Error stats", e); }
            }

            function updateStatValue(id, val) {
                const el = document.getElementById(id);
                if (el) el.textContent = val;
            }

            function refreshData() {
                // Logique simplifiée pour l'exemple, rafraîchit la page pour plus de fiabilité visuelle sur le dashboard
                window.location.reload();
            }

            function approveUser(id) {
                if (confirm('Approuver officiellement ce partenaire Eat&Drink ?')) {
                    performPost(`/dashboard/approuver/${id}`);
                }
            }

            function confirmReject() {
                const id = document.getElementById('rejectUserId').value;
                const motif = document.getElementById('motifRejet').value;
                if (!motif.trim()) { alert('Un motif prestigieux est requis.'); return; }
                performPost(`/dashboard/rejeter/${id}`, { motif_rejet: motif });
            }

            function performPost(url, data = {}) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";
                form.appendChild(csrf);

                for (const [k, v] of Object.entries(data)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = k;
                    input.value = v;
                    form.appendChild(input);
                }

                document.body.appendChild(form);
                form.submit();
            }

            function showRejectModal(id) {
                document.getElementById('rejectUserId').value = id;
                new bootstrap.Modal(document.getElementById('rejectModal')).show();
            }

            function viewDetails(id) {
                alert("Chargement du portfolio du partenaire #" + id + "...");
            }
        </script>
    @endpush
@endsection