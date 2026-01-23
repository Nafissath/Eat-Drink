@extends('layouts.admin')

@section('content')
    <div class="luxury-dashboard animate-fade-in">
        <!-- Header -->
        <div class="header-premium mb-5">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="premium-title">
                        <span class="text-gold"><i class="fas fa-wave-square me-3"></i></span>
                        Flux de <span class="text-gold">Tendances</span>
                    </h1>
                    <p class="premium-subtitle">Surveillance prédictive en temps réel</p>
                </div>
            </div>
        </div>

        <!-- Controls & Info Grid -->
        <div class="row g-4 mb-5 animate-fade-up">
            <div class="col-xl-6">
                <div class="glass-card-luxury p-4 h-100">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-sliders-h text-gold me-3 fs-5"></i>
                        <h5 class="mb-0 fw-bold">Paramètres de Surveillance</h5>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="premium-label">TYPE DE DONNÉES</label>
                            <select id="dataType" class="luxury-select">
                                <option value="commandes">Commandes Signatures</option>
                                <option value="entrepreneurs">Nouveaux Partenaires</option>
                                <option value="produits">Lancements Produits</option>
                                <option value="revenus">Volume de Flux (FCFA)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="premium-label">FENÊTRE TEMPORELLE</label>
                            <select id="period" class="luxury-select">
                                <option value="24h">Dernières 24 Heures</option>
                                <option value="7d">Sept Derniers Jours</option>
                                <option value="30d">Mois en Cours</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <button id="startBtn" class="btn-premium-search w-100">
                                LANCER <i class="fas fa-play ms-2"></i>
                            </button>
                        </div>
                        <div class="col-6">
                            <button id="pauseBtn" class="btn-luxury-outline sm w-100" disabled>
                                PAUSE <i class="fas fa-pause ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="glass-card-luxury p-4 h-100">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-info-circle text-gold me-3 fs-5"></i>
                        <h5 class="mb-0 fw-bold">Analyse Flash</h5>
                    </div>
                    <div class="row g-4 text-center mt-2">
                        <div class="col-6">
                            <div class="mini-glass-card">
                                <h2 class="stat-value text-gold" id="currentValue">0</h2>
                                <p class="row-sub-text mb-0">POINT ACTUEL</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mini-glass-card">
                                <h2 class="stat-value text-emerald" id="trendValue">0%</h2>
                                <p class="row-sub-text mb-0">MOUVEMENT</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Chart -->
        <div class="glass-card-luxury overflow-hidden mb-5 animate-fade-up" style="animation-delay: 0.1s;">
            <div class="card-header-luxury d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chart-line text-gold me-3"></i>
                    <h5 class="mb-0 fw-bold">Moniteur de Flux en Temps Réel</h5>
                </div>
                <div class="indicators-premium">
                    <span id="currentTime" class="badge-luxury">--:--:--</span>
                    <span id="dataTypeLabel" class="badge-luxury ms-2 text-gold">DYNAMIQUE</span>
                </div>
            </div>
            <div class="chart-wrapper-luxury">
                <canvas id="trendChart"></canvas>
                <!-- Overlay Glow -->
                <div class="chart-glow"></div>
            </div>
        </div>

        <!-- Secondary Charts & Alerts -->
        <div class="row g-4 animate-fade-up" style="animation-delay: 0.2s;">
            <div class="col-xl-6">
                <div class="glass-card-luxury p-4 h-100">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-tachometer-alt text-gold me-3 fs-5"></i>
                        <h5 class="mb-0 fw-bold">Vitesse de Croissance</h5>
                    </div>
                    <div class="chart-container-sm">
                        <canvas id="speedChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="glass-card-luxury p-4 h-100">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-bell text-gold me-3 fs-5"></i>
                        <h5 class="mb-0 fw-bold">Notifications de Système</h5>
                    </div>
                    <div id="alertsContainer" class="luxury-alerts-list">
                        <div class="luxury-alert-item info">
                            <i class="fas fa-circle-notch fa-spin me-3"></i> Initialisation de la surveillance...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Specific Styles for Trends Page */
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

        .glass-card-luxury {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
        }

        .card-header-luxury {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .chart-wrapper-luxury {
            height: 450px;
            padding: 2rem;
            position: relative;
            background: radial-gradient(circle at center, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
        }

        .chart-glow {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(to top, rgba(16, 185, 129, 0.05), transparent);
            pointer-events: none;
        }

        .mini-glass-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
        }

        .stat-value {
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .row-sub-text {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .luxury-select {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            color: white;
            font-weight: 500;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='rgba(255,255,255,0.4)'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.25rem;
        }

        .btn-premium-search {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
            border: none;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 800;
            transition: all 0.3s ease;
        }

        .btn-premium-search:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        .btn-premium-search:disabled {
            opacity: 0.5;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .btn-luxury-outline.sm {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-luxury-outline.sm:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
        }

        .badge-luxury {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.4rem 1rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-family: monospace;
        }

        .luxury-alerts-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .luxury-alert-item {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.03);
            border-left: 3px solid transparent;
            animation: slideLeft 0.3s ease-out;
        }

        .luxury-alert-item.info {
            border-left-color: #3b82f6;
            color: #93c5fd;
        }

        .luxury-alert-item.success {
            border-left-color: #10b981;
            color: #a7f3d0;
            background: rgba(16, 185, 129, 0.05);
        }

        .luxury-alert-item.danger {
            border-left-color: #ef4444;
            color: #fca5a5;
            background: rgba(239, 68, 68, 0.05);
        }

        .chart-container-sm {
            height: 250px;
        }

        @keyframes slideLeft {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease-out backwards;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Constants & Logic from previous tendances.blade.php preserved & refined
            let isRunning = false;
            let dataPoints = [];
            const maxPoints = 50;
            let mainChart, speedChart;
            let trend = 0;
            let animationId;

            document.addEventListener('DOMContentLoaded', () => {
                initCharts();
                setupListeners();
            });

            function initCharts() {
                const ctx = document.getElementById('trendChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                mainChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Flux Actuel',
                            data: [],
                            borderColor: '#10b981',
                            borderWidth: 3,
                            fill: true,
                            backgroundColor: gradient,
                            tension: 0.4,
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { display: false },
                            y: {
                                grid: { color: 'rgba(255,255,255,0.05)' },
                                ticks: { color: 'rgba(255,255,255,0.3)', font: { size: 10 } }
                            }
                        },
                        plugins: { legend: { display: false } }
                    }
                });

                const sCtx = document.getElementById('speedChart').getContext('2d');
                speedChart = new Chart(sCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Croissance', 'Stabilité', 'Correction'],
                        datasets: [{
                            data: [33, 33, 33],
                            backgroundColor: ['#10b981', '#d4af37', '#ef4444'],
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        cutout: '80%',
                        plugins: {
                            legend: { position: 'bottom', labels: { color: 'rgba(255,255,255,0.5)', padding: 20 } }
                        }
                    }
                });
            }

            function setupListeners() {
                document.getElementById('startBtn').addEventListener('click', start);
                document.getElementById('pauseBtn').addEventListener('click', pause);

                document.getElementById('dataType').addEventListener('change', (e) => {
                    document.getElementById('dataTypeLabel').textContent = e.target.value.toUpperCase();
                    triggerAlert(`Commutation du flux : ${e.target.value}`, 'info');
                });
            }

            function start() {
                isRunning = true;
                document.getElementById('startBtn').disabled = true;
                document.getElementById('pauseBtn').disabled = false;
                loop();
                triggerAlert("Système de surveillance activé", "success");
            }

            function pause() {
                isRunning = false;
                document.getElementById('startBtn').disabled = false;
                document.getElementById('pauseBtn').disabled = true;
                cancelAnimationFrame(animationId);
                triggerAlert("Surveillance mise en veille", "info");
            }

            function loop() {
                if (!isRunning) return;
                updateData();
                render();
                animationId = requestAnimationFrame(loop);
            }

            function updateData() {
                const last = dataPoints.length ? dataPoints[dataPoints.length - 1] : 50;
                const drift = (Math.random() - 0.5) * 10;
                const next = Math.max(0, last + drift);
                dataPoints.push(next);
                if (dataPoints.length > maxPoints) dataPoints.shift();

                trend = (drift / 10).toFixed(2);
                document.getElementById('currentValue').textContent = Math.round(next);
                document.getElementById('trendValue').textContent = (trend * 100).toFixed(1) + "%";
                document.getElementById('currentTime').textContent = new Date().toLocaleTimeString();
            }

            function render() {
                mainChart.data.labels = dataPoints.map((_, i) => i);
                mainChart.data.datasets[0].data = dataPoints;
                mainChart.update('none');

                // Logic for speedChart update
                const g = Math.abs(trend) > 0.2 ? 60 : 20;
                speedChart.data.datasets[0].data = [g, 30, 100 - g - 30];
                speedChart.update();
            }

            function triggerAlert(msg, type) {
                const container = document.getElementById('alertsContainer');
                const item = document.createElement('div');
                item.className = `luxury-alert-item ${type}`;
                item.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-3"></i> ${msg}`;
                container.prepend(item);
                if (container.children.length > 5) container.lastChild.remove();
            }
        </script>
    @endpush
@endsection