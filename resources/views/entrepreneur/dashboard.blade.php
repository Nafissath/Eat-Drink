{{-- resources/views/entrepreneur/dashboard.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --luxury-gold: #d4af37;
            --luxury-dark: #0f172a;
            --luxury-emerald: #10b981;
            --luxury-glass: rgba(255, 255, 255, 0.03);
            --luxury-glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            color: white;
            min-height: 100vh;
        }

        .dashboard-wrapper {
            padding-top: 2rem;
            padding-bottom: 5rem;
        }

        /* Header Modern */
        .glass-header {
            background: var(--luxury-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 40px;
            padding: 3rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .glass-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Stats Cards */
        .luxury-stat-card {
            background: var(--luxury-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 30px;
            padding: 2rem;
            height: 100%;
            transition: all 0.4s ease;
            position: relative;
        }

        .luxury-stat-card:hover {
            transform: translateY(-10px);
            border-color: var(--luxury-gold);
            background: rgba(255, 255, 255, 0.05);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            background: rgba(212, 175, 55, 0.1);
            color: var(--luxury-gold);
        }

        /* KDS System */
        .order-card-lux {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 25px;
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .order-card-lux.urgent {
            border-color: #ef4444;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.1);
        }

        .order-header-lux {
            padding: 1.2rem;
            background: rgba(255, 255, 255, 0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-body-lux {
            padding: 1.5rem;
        }

        .btn-status-update {
            border-radius: 15px;
            padding: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            width: 100%;
            border: none;
            transition: all 0.3s;
        }

        .btn-status-prep {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
        }

        .btn-status-ready {
            background: var(--luxury-emerald);
            color: white;
        }

        .btn-status-done {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .btn-status-update:hover {
            transform: scale(1.02);
            filter: brightness(1.2);
        }

        /* Charts & Lists */
        .content-box-lux {
            background: var(--luxury-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 35px;
            padding: 2rem;
            height: 100%;
        }

        .table-lux th {
            color: var(--luxury-gold);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 2px;
            border-bottom: 1px solid var(--luxury-glass-border);
            padding: 1rem;
        }

        .table-lux td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            vertical-align: middle;
        }

        .top-product-img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid var(--luxury-gold);
        }

        .animate-fade-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
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
@endpush

@section('content')
    <div class="dashboard-wrapper container">
        <!-- Header Section -->
        <div class="glass-header animate-fade-up">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge rounded-pill px-3 py-2 mb-3"
                        style="background: rgba(212, 175, 55, 0.1); color: var(--luxury-gold); border: 1px solid rgba(212, 175, 55, 0.2)">
                        <i class="fas fa-crown me-2"></i>PARTENAIRE GOLD ELITE
                    </span>
                    <h1 class="display-5 fw-800" style="font-family: 'Playfair Display', serif;">Bonjour,
                        {{ Auth::user()->nom_entreprise }}</h1>
                    <p class="text-white-50 mb-0">Pilotez votre établissement avec les outils de la haute gastronomie.</p>
                </div>
                <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('entrepreneur.produits.index') }}"
                        class="btn btn-outline-light rounded-pill px-4 py-2 me-2 border-opacity-25">
                        <i class="fas fa-utensils me-2"></i>Ma Carte
                    </a>
                    <a href="{{ route('entrepreneur.produits.create') }}"
                        class="btn btn-warning rounded-pill px-4 py-2 fw-800 shadow-lg"
                        style="background: var(--luxury-gold); border: none; color: #0f172a;">
                        <i class="fas fa-plus me-2"></i>Nouveau Plat
                    </a>
                </div>
            </div>
        </div>

        <!-- Overview Stats -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="luxury-stat-card">
                    <div class="icon-box"><i class="fas fa-coins"></i></div>
                    <h6 class="text-white-50 small text-uppercase letter-spacing-2">Chiffre d'Affaires</h6>
                    <h2 class="fw-800 mb-0">{{ number_format($total_ventes, 0, ',', ' ') }} <span
                            class="fs-6 opacity-50">CFA</span></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="luxury-stat-card">
                    <div class="icon-box"><i class="fas fa-shopping-bag"></i></div>
                    <h6 class="text-white-50 small text-uppercase letter-spacing-2">Commandes Jour</h6>
                    <h2 class="fw-800 mb-0">{{ $total_commandes }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="luxury-stat-card">
                    <div class="icon-box"><i class="fas fa-hand-holding-usd"></i></div>
                    <h6 class="text-white-50 small text-uppercase letter-spacing-2">Panier Moyen</h6>
                    <h2 class="fw-800 mb-0">{{ number_format($panier_moyen, 0, ',', ' ') }} <span
                            class="fs-6 opacity-50">CFA</span></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="luxury-stat-card">
                    <div class="icon-box"><i class="fas fa-award"></i></div>
                    <h6 class="text-white-50 small text-uppercase letter-spacing-2">Taux Satisfaction</h6>
                    <h2 class="fw-800 mb-0">98%</h2>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <!-- Live Kitchen (Left) -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-800 mb-0"><i class="fas fa-fire-alt text-warning me-2"></i>Cuisine en Direct</h4>
                    <div id="live-indicator" class="small text-success animate__animated animate__pulse animate__infinite">
                        <i class="fas fa-circle me-1"></i> MONITORING ACTIF
                    </div>
                </div>

                <div class="row g-3" id="kds-container">
                    @php
                        $activeOrders = $commandes->whereIn('statut', ['en_attente', 'en_preparation', 'prete']);
                    @endphp

                    @forelse($activeOrders as $commande)
                        @php
                            $waitingTime = $commande->created_at->diffInMinutes();
                            $isUrgent = $waitingTime > 15 && $commande->statut != 'prete';
                        @endphp
                        <div class="col-md-6 order-item" data-id="{{ $commande->id }}">
                            <div class="order-card-lux {{ $isUrgent ? 'urgent' : '' }}">
                                <div class="order-header-lux">
                                    <div>
                                        <span class="badge bg-dark rounded-pill me-2">#{{ $commande->id }}</span>
                                        <span
                                            class="fw-800">{{ $commande->numero_table ? 'Table ' . $commande->numero_table : 'A Emporter' }}</span>
                                    </div>
                                    <div class="small fw-700 {{ $isUrgent ? 'text-danger' : 'text-white-50' }}">
                                        <i class="far fa-clock me-1"></i>{{ $waitingTime }}min
                                    </div>
                                </div>
                                <div class="order-body-lux">
                                    <ul class="list-unstyled mb-4">
                                        @foreach($commande->produits as $prod)
                                            <li class="d-flex justify-content-between mb-2">
                                                <span><span class="text-gold fw-800">{{ $prod->pivot->quantite }}x</span>
                                                    {{ $prod->nom }}</span>
                                                <i class="fas fa-check-circle text-white-50 small mt-1"></i>
                                            </li>
                                        @endforeach
                                    </ul>

                                    @if($commande->statut == 'en_attente')
                                        <button onclick="updateStatus({{ $commande->id }}, 'en_preparation')"
                                            class="btn-status-update btn-status-prep">Lancer la Préparation</button>
                                    @elseif($commande->statut == 'en_preparation')
                                        <button onclick="updateStatus({{ $commande->id }}, 'prete')"
                                            class="btn-status-update btn-status-ready">Marquer comme Prêt</button>
                                    @elseif($commande->statut == 'prete')
                                        <button onclick="updateStatus({{ $commande->id }}, 'terminee')"
                                            class="btn-status-update btn-status-done">Servi / Archiver</button>
                                    @endif
                                </div>
                                <div class="progress" style="height: 4px; background: rgba(255,255,255,0.05)">
                                    <div class="progress-bar {{ $commande->statut == 'en_preparation' ? 'bg-warning' : 'bg-success' }}"
                                        style="width: {{ $commande->statut == 'en_attente' ? '20%' : ($commande->statut == 'en_preparation' ? '60%' : '100%') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="content-box-lux text-center py-5 opacity-50">
                                <i class="fas fa-concierge-bell fa-4x mb-4 text-white-50"></i>
                                <h4 class="fw-800">Calme plat en cuisine</h4>
                                <p>Les clients arrivent... préparez vos couteaux !</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Analytics Graph -->
                <div class="content-box-lux mt-5">
                    <h5 class="fw-800 mb-4 text-gold text-uppercase letter-spacing-2">Performance de la Journée</h5>
                    <canvas id="salesChart" height="250"></canvas>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div class="col-lg-4">
                <!-- Best Sellers -->
                <div class="content-box-lux mb-4">
                    <h5 class="fw-800 mb-4 text-gold text-uppercase letter-spacing-2">Meilleures Ventes</h5>
                    <div class="top-products-list">
                        @foreach($topProduits as $id => $stats)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $stats['photo'] ? asset('storage/' . $stats['photo']) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c' }}"
                                    class="top-product-img me-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-800">{{ $stats['nom'] }}</h6>
                                    <small class="text-white-50">{{ $stats['total_vendu'] }} vendus</small>
                                </div>
                                <div class="text-gold fw-800 small">{{ number_format($stats['revenu'], 0, ',', ' ') }} CFA</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tips & Advice -->
                <div class="content-box-lux"
                    style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, transparent 100%);">
                    <div class="text-center">
                        <div class="mb-3 text-gold fs-1"><i class="fas fa-lightbulb"></i></div>
                        <h5 class="fw-800 mb-3">Conseil de Chef</h5>
                        <p class="text-white-50 italic small mb-4">
                            "Les commandes 'A Emporter' augmentent entre 12h et 14h. Soyez prêt à accélérer le rythme !"
                        </p>
                        <button class="btn btn-sm btn-outline-gold rounded-pill px-4"
                            style="color: var(--luxury-gold); border-color: var(--luxury-gold);">Voir plus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Sales Chart
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesData = @json(array_values($salesByHour));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array.from({ length: 24 }, (_, i) => `${i}h`),
                    datasets: [{
                        label: 'Ventes (CFA)',
                        data: salesData,
                        borderColor: '#d4af37',
                        backgroundColor: 'rgba(212, 175, 55, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,0.5)' } },
                        x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.5)' } }
                    }
                }
            });

            function updateStatus(id, newStatus) {
                const btn = event.target;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(`/entrepreneur/commandes/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ statut: newStatus })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Erreur: ' + (data.message || 'Mise à jour impossible'));
                            btn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Erreur de connexion au serveur');
                        btn.disabled = false;
                    });
            }
        </script>
    @endpush
@endsection