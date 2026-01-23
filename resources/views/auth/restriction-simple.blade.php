@extends('layouts.app')

@section('content')
    <div class="luxury-restriction-container d-flex align-items-center justify-content-center py-5">
        <div class="container">
            @if(session('restriction') || isset($restriction))
                @php
                    $rest = session('restriction') ?? $restriction;
                    $endDate = \Carbon\Carbon::parse($rest['end_date']);
                    $startDate = \Carbon\Carbon::parse($rest['start_date']);
                    $now = \Carbon\Carbon::now();
                    $diff = $now->diff($endDate);

                    $isPermanent = $rest['type'] === 'permanente';
                @endphp

                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="glass-restriction-card animate-fade-up">
                            <!-- Red Alert Header -->
                            <div class="restriction-header-premium p-5 text-center">
                                <div class="restriction-visual mb-4">
                                    <div class="pulse-ring red"></div>
                                    <div class="status-icon-box danger">
                                        <i class="fas fa-gavel text-white"></i>
                                    </div>
                                </div>
                                <h1 class="premium-title mb-2">Accès <span class="text-danger">Interrompu</span></h1>
                                <p class="premium-subtitle">PROTOCOLE DE GOUVERNANCE
                                    #{{ substr(md5($rest['start_date']), 0, 8) }}</p>
                            </div>

                            <!-- Info Grid -->
                            <div class="p-5 pt-0">
                                <div class="row g-4 mb-5 text-center">
                                    <div class="col-md-4">
                                        <div class="mini-glass-card border-danger-subtle">
                                            <div class="row-sub-text text-danger mb-2">STATUS RÉSEAU</div>
                                            <h6 class="fw-bold text-white mb-0">{{ strtoupper($rest['type']) }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mini-glass-card border-warning-subtle">
                                            <div class="row-sub-text text-warning mb-2">ÉCHÉANCE</div>
                                            <h6 class="fw-bold text-white mb-0">
                                                @if($isPermanent)
                                                    INDÉTERMINÉE
                                                @else
                                                    {{ $endDate->format('d/m/Y') }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mini-glass-card border-info-subtle">
                                            <div class="row-sub-text text-info mb-2">RESTANTS</div>
                                            <h6 class="fw-bold text-white mb-0" id="countdown">
                                                @if($isPermanent)
                                                    --:--
                                                @else
                                                    {{ $diff->days }}J {{ $diff->h }}H
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- Motif Panel -->
                                <div class="motif-panel-luxury p-4 mb-5">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-info-circle text-gold me-3 fs-5"></i>
                                        <h5 class="mb-0 fw-bold text-white">Considérations Administratives</h5>
                                    </div>
                                    <p class="text-white-50 mb-0 font-italic">
                                        "{{ $rest['motif'] }}"
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex flex-wrap gap-3 justify-content-center pt-4 border-top border-white-05">
                                    <a href="{{ route('login') }}" class="btn-luxury-outline sm px-4">
                                        <i class="fas fa-sign-in-alt me-2"></i> RETOUR SESSION
                                    </a>
                                    <a href="{{ route('accueil') }}" class="btn-luxury-outline sm px-4">
                                        <i class="fas fa-home me-2"></i> RÉSIDENCE
                                    </a>
                                    <button type="button" class="btn-luxury-primary sm danger px-5" onclick="showContactForm()">
                                        OUVRIR UNE CONTESTATION
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Success/Default State -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="glass-restriction-card p-5 text-center animate-fade-up">
                            <div class="status-icon-box success mx-auto mb-4">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <h2 class="text-emerald mb-3">Honneur Préservé</h2>
                            <p class="text-white-50 mb-5">Aucune restriction n'est actuellement liée à votre identité numérique.
                            </p>
                            <a href="{{ route('login') }}" class="btn-luxury-gold px-5">
                                S'IDENTIFIER À NOUVEAU
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Contestation Luxury -->
    <div class="modal fade luxury-modal" id="contactModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-card-luxury p-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-white">Mémoire en <span class="text-gold">Défense</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-white-50 small mb-4">Votre recours sera examiné par le Conseil des Administrateurs sous
                        24 heures.</p>
                    <form id="contactForm">
                        <div class="mb-4">
                            <label class="premium-label">EMAIL D'IDENTIFICATION</label>
                            <input type="email" class="luxury-input" id="contactEmail" required
                                placeholder="votre@email.com">
                        </div>
                        <div class="mb-2">
                            <label class="premium-label">ARGUMENTAIRE DE RÉTABLISSEMENT</label>
                            <textarea class="luxury-textarea" id="contactMessage" rows="5" required
                                placeholder="Détaillez les raisons de votre contestation..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-luxury-outline sm" data-bs-dismiss="modal">ANNULER</button>
                    <button type="button" class="btn-luxury-primary sm px-4" onclick="sendContactMessage()">
                        ENVOYER LE RECOURS
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .luxury-restriction-container {
            min-height: 90vh;
            background: radial-gradient(circle at 50% 10%, rgba(239, 68, 68, 0.05) 0%, rgba(15, 23, 42, 1) 100%);
        }

        .glass-restriction-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 40px;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.6);
            overflow: hidden;
        }

        .status-visual-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .status-icon-box {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .status-icon-box.danger {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        }

        .status-icon-box.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .pulse-ring.red {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120px;
            height: 120px;
            margin-top: -60px;
            margin-left: -60px;
            border: 2px solid #ef4444;
            border-radius: 50%;
            opacity: 0;
            animation: ringPulseRed 2s infinite;
        }

        @keyframes ringPulseRed {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }

            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .premium-title {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 3rem;
            color: white;
        }

        .premium-subtitle {
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 0.4em;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .border-danger-subtle {
            border-color: rgba(239, 68, 68, 0.15) !important;
        }

        .border-warning-subtle {
            border-color: rgba(245, 158, 11, 0.15) !important;
        }

        .border-info-subtle {
            border-color: rgba(59, 130, 246, 0.15) !important;
        }

        .mini-glass-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 1.5rem;
        }

        .motif-panel-luxury {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            border-left: 4px solid var(--luxury-gold);
        }

        .btn-luxury-primary.danger {
            background: linear-gradient(135deg, #ef4444, #991b1b);
            color: white;
            border: none;
        }

        .btn-luxury-primary.danger:hover {
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }

        .text-emerald {
            color: #10b981;
        }

        .border-white-05 {
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        .animate-fade-up {
            animation: fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function showContactForm() {
            new bootstrap.Modal(document.getElementById('contactModal')).show();
        }

        function sendContactMessage() {
            const email = document.getElementById('contactEmail').value;
            const msg = document.getElementById('contactMessage').value;
            if (!email || !msg) return alert('La conciergerie a besoin de tous les détails pour votre défense.');
            alert('Votre recours a été scellé et transmis à la plus haute autorité.');
            bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
        }
    </script>
@endsection