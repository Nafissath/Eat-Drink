@extends('layouts.admin')

@section('content')
    <div class="luxury-dashboard animate-fade-in">
        <!-- Header -->
        <div class="header-premium mb-5">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="premium-title">
                        <span class="text-gold"><i class="fas fa-shield-alt me-3"></i></span>
                        Gouvernance <span class="text-gold">& Restrictions</span>
                    </h1>
                    <p class="premium-subtitle">Gestion de l'intégrité et de la conformité du réseau</p>
                </div>
                <div class="col-auto">
                    <div class="btn-group-luxury">
                        <button class="btn-luxury-action" onclick="refreshData()">
                            <i class="fas fa-sync-alt me-2"></i> Actualiser
                        </button>
                        <button class="btn-luxury-action secondary" onclick="exportRestrictions()">
                            <i class="fas fa-file-export me-2"></i> Exporter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Metrics Grid -->
        <div class="row g-4 mb-5 animate-fade-up">
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-gold-gradient">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">COMPTES RESTREINTS</p>
                        <h2 class="stat-value" id="restrictedCount">{{ $restrictions->where("is_active", true)->count() }}
                        </h2>
                    </div>
                    <div class="stat-glow gold"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-emerald-gradient">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">COMPTES ACTIFS</p>
                        <h2 class="stat-value" id="activeCount">
                            {{ $entrepreneurs->count() - $restrictions->where("is_active", true)->count() }}</h2>
                    </div>
                    <div class="stat-glow emerald"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-blue-gradient">
                        <i class="fas fa-hourglass-end"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">EXPIRATIONS (24H)</p>
                        <h2 class="stat-value" id="expiringToday">
                            {{ $restrictions->filter(function ($r) {
        return $r->end_date->isToday(); })->count() }}</h2>
                    </div>
                    <div class="stat-glow blue"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-stopwatch-gradient">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">RESTRICTIONS (MOIS)</p>
                        <h2 class="stat-value" id="monthlyRestrictions">
                            {{ $restrictions->where("created_at", ">=", now()->startOfMonth())->count() }}</h2>
                    </div>
                    <div class="stat-glow purple"></div>
                </div>
            </div>
        </div>

        <!-- Feedback Alerts -->
        @if(session('status'))
            <div class="luxury-alert-floating success animate-fade-in">
                <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
            </div>
        @endif

        <!-- New Restriction Form -->
        <div class="glass-card-luxury p-4 mb-5 animate-fade-up" style="animation-delay: 0.1s;">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-plus-circle text-gold me-3 fs-4"></i>
                <h5 class="mb-0 fw-bold">Émettre une Nouvelle Restriction Signature</h5>
            </div>
            <form id="restrictionForm" method="POST" action="{{ route('admin.restrictions.store') }}">
                @csrf
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="premium-label">SÉLECTIONNER LE PARTENAIRE</label>
                        <select class="luxury-select" id="entrepreneur_id" name="entrepreneur_id" required>
                            <option value="">Choisir un ambassadeur...</option>
                            @foreach($entrepreneurs as $entrepreneur)
                                <option value="{{ $entrepreneur->id }}">
                                    {{ $entrepreneur->nom_entreprise }} ({{ $entrepreneur->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="premium-label">TYPE DE MESURE</label>
                        <select class="luxury-select" id="restriction_type" name="restriction_type" required>
                            <option value="">Nature de la décision...</option>
                            <option value="temporaire">Temporaire (Suspension)</option>
                            <option value="permanente">Permanente (Exclusion)</option>
                            <option value="avertissement">Avertissement Officiel</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="premium-label">DURÉE (JOURS)</label>
                        <input type="number" class="luxury-input" id="duration" name="duration" min="1" max="365"
                            placeholder="Ex: 7 jours" required>
                    </div>
                    <div class="col-md-2">
                        <label class="premium-label">DATE D'EFFET</label>
                        <input type="date" class="luxury-input" id="start_date" name="start_date"
                            value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-12">
                        <label class="premium-label">JUSTIFICATION DE HAUT NIVEAU</label>
                        <textarea class="luxury-textarea" id="motif" name="motif" rows="3"
                            placeholder="Détaillez les raisons de cette mesure avec précision..." required></textarea>
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn-premium-search px-5">
                            APPLIQUER LA DÉCISION <i class="fas fa-gavel ms-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Active Restrictions Table -->
        <div class="glass-card-luxury p-0 overflow-hidden animate-fade-up" style="animation-delay: 0.2s;">
            <div class="card-header-luxury d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list-ul text-gold me-3"></i>
                    <h5 class="mb-0 fw-bold">Mesures de Protection Actives</h5>
                </div>
                <span class="badge-luxury" id="restrictionsCount">{{ $restrictions->count() }} PROTOCOLES</span>
            </div>

            <div class="luxury-table-container">
                @if($restrictions->isEmpty())
                    <div class="empty-state-luxury text-center py-5">
                        <i class="fas fa-shield-virus text-emerald fs-1 mb-3"></i>
                        <h4>Sérénité Totale</h4>
                        <p class="text-white-50">Aucun protocole de restriction n'est actuellement déployé.</p>
                    </div>
                @else
                    <table class="luxury-table">
                        <thead>
                            <tr>
                                <th>PARTENAIRE</th>
                                <th>NATURE</th>
                                <th>PÉRIODE</th>
                                <th>ÉCHÉANCE</th>
                                <th>VIGUEUR</th>
                                <th class="text-end">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($restrictions as $restriction)
                                <tr class="luxury-row">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-luxury">
                                                {{ strtoupper(substr($restriction->entrepreneur->email, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="row-main-text">{{ $restriction->entrepreneur->nom_entreprise }}</div>
                                                <div class="row-sub-text">{{ $restriction->entrepreneur->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-type-luxury {{ $restriction->type }}">
                                            {{ strtoupper($restriction->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="row-main-text">{{ $restriction->start_date->format('d/m/Y') }}</div>
                                        <div class="row-sub-text">{{ $restriction->start_date->format('H:i') }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $endDate = \Carbon\Carbon::parse($restriction->start_date)->addDays($restriction->duration);
                                            $isExpired = $endDate->isPast();
                                            $daysLeft = now()->diffInDays($endDate, false);
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="wait-badge-luxury {{ $isExpired ? 'urgent' : ($daysLeft <= 3 ? 'warning' : 'optimal') }}">
                                                {{ $endDate->format('d/m/Y') }}
                                            </div>
                                        </div>
                                        <div class="row-sub-text mt-1">
                                            {{ $isExpired ? 'Expiré' : $daysLeft . ' jours restants' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($restriction->is_active)
                                            <span class="pulse-active-danger"><i class="fas fa-circle me-1"></i> ACTIF</span>
                                        @else
                                            <span class="text-white-50 small">RÉACTIVER</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="action-stack">
                                            @if($restriction->is_active)
                                                <button class="btn-action-luxury success" title="Réactiver"
                                                    onclick="activateAccount('{{ $restriction->id }}')">
                                                    <i class="fas fa-unlock"></i>
                                                </button>
                                            @else
                                                <button class="btn-action-luxury warning" title="Prolonger"
                                                    onclick="extendRestriction('{{ $restriction->id }}')">
                                                    <i class="far fa-clock"></i>
                                                </button>
                                            @endif
                                            <button class="btn-action-luxury info" title="Détails"
                                                onclick="viewRestrictionDetails('{{ $restriction->id }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-action-luxury danger" title="Supprimer"
                                                onclick="deleteRestriction('{{ $restriction->id }}')">
                                                <i class="fas fa-trash"></i>
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
    </div>

    <!-- Modal Styles Reused & Refined -->
    <style>
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

        /* Custom Badges */
        .badge-type-luxury {
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .badge-type-luxury.permanente {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .badge-type-luxury.temporaire {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .badge-type-luxury.avertissement {
            background: rgba(245, 158, 11, 0.15);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .pulse-active-danger {
            color: #ef4444;
            font-size: 0.75rem;
            font-weight: 800;
            animation: pulseFade 2s infinite;
        }

        @keyframes pulseFade {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Alert Floating */
        .luxury-alert-floating {
            background: rgba(16, 185, 129, 0.9);
            backdrop-filter: blur(10px);
            color: white;
            padding: 1rem 2rem;
            border-radius: 15px;
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 9999;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        /* Standard Luxury Tokens Reused */
        .glass-card-luxury {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
        }

        .luxury-input,
        .luxury-select,
        .luxury-textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.8rem 1.25rem;
            color: white;
            font-weight: 500;
        }

        .premium-label {
            font-size: 0.65rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 0.6rem;
            display: block;
            letter-spacing: 0.1em;
        }

        .btn-premium-search {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 800;
            transition: all 0.3s ease;
        }

        .btn-premium-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
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
            color: white;
        }

        .row-sub-text {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .wait-badge-luxury {
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
            transition: all 0.3s;
        }

        .btn-action-luxury:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-action-luxury.success:hover {
            background: #10b981;
        }

        .btn-action-luxury.warning:hover {
            background: #f59e0b;
        }

        .btn-action-luxury.danger:hover {
            background: #ef4444;
        }

        .btn-action-luxury.info:hover {
            background: #3b82f6;
        }

        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease-out backwards;
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
    </style>

    @push('scripts')
        <script>
            function activateAccount(id) {
                if (confirm('Réhabiliter ce partenaire avec les honneurs Eat&Drink ?')) {
                    performPost(`/dashboard/restrictions/${id}/activate`);
                }
            }

            function deleteRestriction(id) {
                if (confirm('Supprimer définitivement ce protocole ?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/dashboard/restrictions/${id}`;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = "{{ csrf_token() }}";
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            }

            function performPost(url) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }

            function refreshData() { location.reload(); }
            function exportRestrictions() { alert('Génération du rapport de gouvernance...'); }
            function viewRestrictionDetails(id) { alert("Analyse cryptée du dossier #" + id); }
        </script>
    @endpush
@endsection