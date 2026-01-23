@extends('layouts.admin')

@section('content')
    <div class="luxury-dashboard animate-fade-in">
        <!-- Header -->
        <div class="header-premium mb-5">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="premium-title">
                        <span class="text-gold"><i class="fas fa-chart-pie me-3"></i></span>
                        Analyses <span class="text-gold">Statistiques</span>
                    </h1>
                    <p class="premium-subtitle">Performance globale de l'écosystème Eat&Drink</p>
                </div>
            </div>
        </div>

        <!-- Key Metrics Grid -->
        <div class="row g-4 mb-5 animate-fade-up">
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-emerald-gradient">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">ENTREPRENEURS APPROUVÉS</p>
                        <h2 class="stat-value">{{ $stats['entrepreneurs_approuves'] }}</h2>
                    </div>
                    <div class="stat-glow emerald"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-gold-gradient">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">DEMANDES EN ATTENTE</p>
                        <h2 class="stat-value">{{ $stats['demandes_attente'] }}</h2>
                    </div>
                    <div class="stat-glow gold"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-blue-gradient">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">TOTAL COMMANDES</p>
                        <h2 class="stat-value">{{ $stats['total_commandes'] }}</h2>
                    </div>
                    <div class="stat-glow blue"></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="glass-stat-card">
                    <div class="stat-icon-box bg-stopwatch-gradient">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">PRODUITS SIGNATURE</p>
                        <h2 class="stat-value">{{ $stats['total_produits'] }}</h2>
                    </div>
                    <div class="stat-glow purple"></div>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="row g-5 mb-5">
            <!-- Top Partners -->
            <div class="col-xl-6">
                <div class="glass-card-luxury h-100 animate-fade-up" style="animation-delay: 0.1s;">
                    <div class="card-header-luxury border-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-award text-gold me-3 fs-4"></i>
                            <h5 class="mb-0 fw-bold">Ambassadeurs d'Excellence</h5>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        @if($top_entrepreneurs->isEmpty())
                            <div class="empty-state-luxury text-center py-5">
                                <i class="fas fa-ghost text-white-50 fs-1 mb-3"></i>
                                <p class="text-white-50">Aucune donnée de performance</p>
                            </div>
                        @else
                            @foreach($top_entrepreneurs as $index => $entrepreneur)
                                <div class="luxury-list-item animate-row">
                                    <div class="index-badge bg-gold-gradient">{{ $index + 1 }}</div>
                                    <div class="item-main">
                                        <div class="row-main-text">{{ $entrepreneur->nom_entreprise }}</div>
                                        <div class="row-sub-text">{{ $entrepreneur->email }}</div>
                                    </div>
                                    <div class="item-meta text-end">
                                        <div class="text-gold fw-bold">{{ $entrepreneur->total_commandes }} Ventes</div>
                                        <div class="row-sub-text">{{ number_format($entrepreneur->total_ventes, 0) }} FCFA</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Time-Based Stats -->
            <div class="col-xl-6">
                <div class="glass-card-luxury h-100 animate-fade-up" style="animation-delay: 0.2s;">
                    <div class="card-header-luxury border-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-gold me-3 fs-4"></i>
                            <h5 class="mb-0 fw-bold">Dynamique Temporelle</h5>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        <div class="luxury-section-title mb-4">
                            <span class="text-emerald"><i class="fas fa-bolt me-2"></i></span> SEPT DERNIERS JOURS
                        </div>
                        <div class="row g-3 mb-5">
                            <div class="col-6">
                                <div class="mini-glass-card shadow-sm">
                                    <h3 class="stat-value text-emerald">{{ $stats['commandes_semaine'] }}</h3>
                                    <p class="row-sub-text mb-0">RÉSERVATIONS</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mini-glass-card shadow-sm">
                                    <h3 class="stat-value text-gold">{{ $stats['nouveaux_entrepreneurs'] }}</h3>
                                    <p class="row-sub-text mb-0">PARTENAIRES</p>
                                </div>
                            </div>
                        </div>

                        <div class="luxury-section-title mb-4">
                            <span class="text-gold"><i class="fas fa-gem me-2"></i></span> BILAN MENSUEL
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="mini-glass-card shadow-sm">
                                    <h3 class="stat-value text-blue">{{ $stats['commandes_mois'] }}</h3>
                                    <p class="row-sub-text mb-0">EXPÉRIENCES</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mini-glass-card shadow-sm">
                                    <h3 class="stat-value text-gold-faded">
                                        {{ number_format($stats['chiffre_affaires_mois'], 0) }}</h3>
                                    <p class="row-sub-text mb-0">FCFA VOLUME</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="glass-card-luxury animate-fade-up" style="animation-delay: 0.3s;">
            <div class="card-header-luxury">
                <div class="d-flex align-items-center">
                    <i class="fas fa-stream text-gold me-3"></i>
                    <h5 class="mb-0 fw-bold">Journal des Activités de Prestige</h5>
                </div>
            </div>
            <div class="luxury-table-container">
                @if($activites_recentes->isEmpty())
                    <p class="text-center py-5 text-white-50">Aucun mouvement récent noté.</p>
                @else
                    <table class="luxury-table">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>PARTENAIRE</th>
                                <th>ACTION</th>
                                <th class="text-end">DÉTAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activites_recentes as $activite)
                                <tr class="luxury-row">
                                    <td class="row-sub-text">{{ $activite->created_at->format('d/m H:i') }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $activite->nom_entreprise }}</div>
                                    </td>
                                    <td>
                                        @if($activite->type === 'commande')
                                            <span class="wait-badge-luxury optimal">COMMANDE</span>
                                        @elseif($activite->type === 'approbation')
                                            <span class="wait-badge-luxury warning">APPROBATION</span>
                                        @elseif($activite->type === 'produit')
                                            <span class="wait-badge-luxury optimal">PRODUIT</span>
                                        @endif
                                    </td>
                                    <td class="text-end text-white-50">
                                        <small>{{ $activite->details }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Specific Styles for Statistics Page */
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

        /* Stat Cards (Already defined in layout but reused) */
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
        }

        .stat-icon-box {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-right: 1.25rem;
            z-index: 2;
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-weight: 800;
            margin-bottom: 0;
            font-size: 1.85rem;
        }

        /* Gradients & Glows */
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
            width: 80px;
            height: 80px;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.15;
            right: -20px;
            top: -20px;
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

        /* Luxury List */
        .luxury-list-item {
            display: flex;
            align-items: center;
            padding: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            transition: all 0.3s ease;
        }

        .luxury-list-item:last-child {
            border-bottom: none;
        }

        .luxury-list-item:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .index-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 800;
            margin-right: 1.25rem;
        }

        .row-main-text {
            font-weight: 700;
            color: white;
        }

        .row-sub-text {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .mini-glass-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
        }

        .luxury-section-title {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.2em;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Colors */
        .text-emerald {
            color: #10b981;
        }

        .text-gold {
            color: #d4af37;
        }

        .text-blue {
            color: #3b82f6;
        }

        .text-gold-faded {
            color: #f1c40f;
        }

        /* Tables */
        .glass-card-luxury {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
        }

        .card-header-luxury {
            padding: 2rem;
        }

        .luxury-table {
            width: 100%;
            border-collapse: separate;
        }

        .luxury-table th {
            padding: 1.25rem 2rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
        }

        .luxury-table td {
            padding: 1.25rem 2rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .wait-badge-luxury {
            padding: 0.25rem 0.6rem;
            border-radius: 5px;
            font-size: 0.7rem;
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
@endsection