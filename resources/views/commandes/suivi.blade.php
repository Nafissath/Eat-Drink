@extends('layouts.app')

@section('content')
    @php
        $suiviUrl = URL::signedRoute('commandes.suivi', ['id' => $commande->id]);
        $statusUrl = URL::signedRoute('commandes.suivi.status', ['id' => $commande->id]);
        $modifierUrl = URL::signedRoute('commandes.modifier', ['id' => $commande->id]);
        $annulerUrl = URL::signedRoute('commandes.annulerClient', ['id' => $commande->id]);

        $steps = [
            'en_attente' => ['label' => 'En Attente', 'icon' => 'fa-clock'],
            'en_preparation' => ['label' => 'Préparation', 'icon' => 'fa-utensils'],
            'prete' => ['label' => 'Prête', 'icon' => 'fa-bell'],
            'en_livraison' => ['label' => 'Expédition', 'icon' => 'fa-motorcycle'],
            'terminee' => ['label' => 'Terminée', 'icon' => 'fa-check-double'],
        ];

        $current = $commande->statut;
    @endphp

    <div class="luxury-suivi-page py-5 animate-fade-in">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Hero Header -->
                    <div class="glass-hero-suivi mb-5 p-5 text-center animate-fade-up">
                        <div class="badge-status-top mb-3" id="mainBadge">
                            {{ strtoupper(str_replace('_', ' ', $commande->statut)) }}
                        </div>
                        <h1 class="premium-title">Suivi de votre <span class="text-gold">Expérience</span></h1>
                        <p class="premium-subtitle mb-0">RÉFÉRENCE #{{ $commande->id }} •
                            {{ strtoupper($commande->type_commande) }}</p>

                        <div class="update-pulse mt-4">
                            <span class="pulse-dot"></span>
                            SYNCHRONISATION EN TEMPS RÉEL
                        </div>
                    </div>

                    <!-- Status Progress bar -->
                    <div class="glass-card-luxury p-5 mb-5 animate-fade-up" style="animation-delay: 0.1s;">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="fw-bold mb-0"><i class="fas fa-stream text-gold me-3"></i>Progression Logistique</h4>
                            <div class="text-white-50 small" id="lastUpdate">MAJ:
                                {{ $commande->updated_at?->format('H:i:s') }}</div>
                        </div>

                        <div class="luxury-progress-wrapper">
                            <div class="progress-line"></div>
                            <div class="progress-line-active" id="progressLine"></div>

                            <div class="steps-container d-flex justify-content-between">
                                @foreach($steps as $key => $step)
                                    <div class="step-item" id="step-{{ $key }}">
                                        <div class="step-circle">
                                            <i class="fas {{ $step['icon'] }}"></i>
                                        </div>
                                        <div class="step-label mt-3">{{ $step['label'] }}</div>
                                        <div class="step-time row-sub-text" id="time-{{ $key }}"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="row g-4 mb-5 animate-fade-up" style="animation-delay: 0.2s;">
                        <div class="col-md-6">
                            <div class="glass-card-luxury p-4 h-100">
                                <h5 class="fw-bold mb-4 text-gold border-bottom pb-2 border-white-10">Configuration de
                                    l'Offre</h5>
                                <div class="luxury-info-row mb-3">
                                    <span class="label">DATE</span>
                                    <span class="value">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="luxury-info-row mb-3">
                                    <span class="label">DESTINATION</span>
                                    <span class="value">
                                        @if($commande->type_commande === 'sur_place')
                                            TABLE #{{ $commande->numero_table }}
                                        @else
                                            {{ $commande->adresse }}, {{ $commande->ville }}
                                        @endif
                                    </span>
                                </div>
                                <div class="luxury-info-row mb-3">
                                    <span class="label">BÉNÉFICIAIRE</span>
                                    <span class="value">{{ $commande->nom_client }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="glass-card-luxury p-4 h-100">
                                <h5 class="fw-bold mb-4 text-gold border-bottom pb-2 border-white-10">Sommaire Financier
                                </h5>
                                <div class="luxury-info-row mb-3 total">
                                    <span class="label">VALEUR TOTALE</span>
                                    <span class="value">{{ number_format($commande->total, 0) }} FCFA</span>
                                </div>
                                <div class="d-flex gap-2 mt-4">
                                    <a href="{{ URL::signedRoute('commandes.telechargerRecu', ['id' => $commande->id]) }}"
                                        class="btn-luxury-outline sm w-100">
                                        <i class="fas fa-file-pdf me-2"></i> REÇU PDF
                                    </a>
                                    @if($commande->statut === 'en_attente')
                                        <button class="btn-luxury-outline sm danger w-100" data-bs-toggle="modal"
                                            data-bs-target="#annulerModal">
                                            ANNULER
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="text-center mt-5">
                        <a href="{{ route('accueil') }}" class="btn-luxury-link">
                            <i class="fas fa-chevron-left me-2"></i> RETOUR AU CATALOUE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Annulation Premium -->
    <div class="modal fade luxury-modal" id="annulerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-card-luxury">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Rupture de <span class="text-gold">Protocole</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ $annulerUrl }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-white-50 mb-4">Veuillez indiquer la raison du désistement pour cette commande
                            prestigieuse.</p>
                        <textarea class="luxury-textarea" name="motif_annulation" rows="3"
                            placeholder="Motif (optionnel)..."></textarea>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn-luxury-outline sm" data-bs-dismiss="modal">RETOUR</button>
                        <button type="submit" class="btn-luxury-primary sm danger">CONFIRMER L'ANNULATION</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .luxury-suivi-page {
            min-height: 100vh;
            background: radial-gradient(circle at 50% 0%, rgba(30, 41, 59, 0.4) 0%, rgba(15, 23, 42, 1) 100%);
        }

        .glass-hero-suivi {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 40px;
        }

        .badge-status-top {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: rgba(212, 175, 55, 0.1);
            color: var(--luxury-gold);
            border: 1px solid var(--luxury-gold);
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 0.2em;
        }

        .premium-title {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 3rem;
            color: white;
        }

        .premium-subtitle {
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.3em;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .update-pulse {
            font-size: 0.65rem;
            font-weight: 800;
            color: rgba(16, 185, 129, 0.8);
            letter-spacing: 0.1em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
            animation: pulseEffect 1.5s infinite;
        }

        @keyframes pulseEffect {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: 0.5;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Progress Bar Luxury */
        .luxury-progress-wrapper {
            position: relative;
            padding: 2rem 0;
        }

        .progress-line {
            position: absolute;
            top: 50px;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 2px;
        }

        .progress-line-active {
            position: absolute;
            top: 50px;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(to right, #d4af37, #10b981);
            border-radius: 2px;
            transition: width 1s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .steps-container {
            position: relative;
            z-index: 2;
        }

        .step-item {
            text-align: center;
            width: 100px;
            transition: all 0.5s ease;
            opacity: 0.3;
        }

        .step-item.active {
            opacity: 1;
        }

        .step-item.completed {
            opacity: 0.6;
        }

        .step-circle {
            width: 60px;
            height: 60px;
            background: rgba(15, 23, 42, 1);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 1.25rem;
            color: white;
            transition: all 0.5s ease;
        }

        .step-item.active .step-circle {
            border-color: var(--luxury-gold);
            color: var(--luxury-gold);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
            transform: scale(1.1);
        }

        .step-item.completed .step-circle {
            background: var(--luxury-gold);
            border-color: var(--luxury-gold);
            color: #0f172a;
        }

        .step-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: white;
            letter-spacing: 0.05em;
        }

        /* Info Rows */
        .luxury-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .luxury-info-row .label {
            font-size: 0.65rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.1em;
        }

        .luxury-info-row .value {
            font-weight: 700;
            color: white;
            font-size: 0.95rem;
        }

        .luxury-info-row.total .value {
            color: var(--luxury-gold);
            font-size: 1.25rem;
        }

        .border-white-10 {
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        .btn-luxury-outline.sm {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.75rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.8rem;
            transition: all 0.3s;
        }

        .btn-luxury-outline.sm:hover {
            background: white;
            color: black;
            border-color: white;
        }

        .btn-luxury-outline.sm.danger:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        .btn-luxury-link {
            color: var(--luxury-gold);
            font-weight: 800;
            font-size: 0.8rem;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s;
        }

        .btn-luxury-link:hover {
            color: white;
            transform: translateX(-5px);
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-fade-up {
            animation: fadeUp 0.8s backwards;
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
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @push('scripts')
        <script>
            const statusUrl = @json($statusUrl);
            const steps = ['en_attente', 'en_preparation', 'prete', 'en_livraison', 'terminee'];

            function updateUI(statut) {
                const idx = steps.indexOf(statut);
                const progressLine = document.getElementById('progressLine');
                const mainBadge = document.getElementById('mainBadge');

                // Update progress line
                const percent = (Math.max(0, idx) / (steps.length - 1)) * 100;
                progressLine.style.width = percent + '%';

                // Update badge
                mainBadge.textContent = statut.replaceAll('_', ' ').toUpperCase();
                mainBadge.className = 'badge-status-top ' + (statut === 'annulee' ? 'bg-danger text-white' : '');

                // Update steps
                steps.forEach((key, i) => {
                    const el = document.getElementById(`step-${key}`);
                    if (!el) return;

                    el.classList.remove('active', 'completed');
                    if (i < idx) el.classList.add('completed');
                    else if (i === idx) el.classList.add('active');
                });
            }

            async function refreshStatus() {
                try {
                    const res = await fetch(statusUrl, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) return;
                    const data = await res.json();

                    if (data && data.statut) {
                        updateUI(data.statut);
                        if (document.getElementById('lastUpdate')) {
                            document.getElementById('lastUpdate').textContent = 'MAJ: ' + new Date().toLocaleTimeString();
                        }
                    }
                } catch (e) {
                    console.warn("Refresh failed", e);
                }
            }

            updateUI(@json($commande->statut));
            setInterval(refreshStatus, 8000);
        </script>
    @endpush
@endsection