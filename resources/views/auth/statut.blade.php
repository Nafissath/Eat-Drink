@extends('layouts.app')

@section('content')
    <div class="luxury-status-container d-flex align-items-center justify-content-center py-5">
        <div class="glass-status-card animate-fade-up text-center">
            <!-- Icon/Visual -->
            <div class="status-visual-wrapper mb-5">
                <div class="waiting-rings">
                    <div class="ring"></div>
                    <div class="ring"></div>
                    <div class="ring"></div>
                </div>
                <div class="status-icon-box">
                    <i class="fas fa-hourglass-half text-gold"></i>
                </div>
            </div>

            <!-- Content -->
            <h1 class="premium-title mb-3">En attente de <span class="text-gold">Privilèges</span></h1>
            <p class="premium-subtitle mb-4">ÉTUDE DE VOTRE PROTOCOLE D'ADHÉSION</p>

            <div class="status-message-box mb-5">
                <p class="text-white opacity-90 fs-5 mb-4">
                    Merci d'avoir choisi <span class="text-gold fw-bold">Eat&Drink Premium</span>.
                </p>
                <p class="text-white-50 small mb-0 px-md-5">
                    Votre demande d'accréditation est actuellement entre les mains de notre comité d'experts. Nous analysons
                    votre dossier avec la plus grande attention pour garantir l'excellence de notre réseau.
                </p>
            </div>

            <!-- Notification Alert -->
            <div class="luxury-alert-item warning mb-5 animate-pulse-subtle">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-shield-alt me-3 text-gold"></i>
                    <span class="small fw-800 letter-spacing-1">NOTIFICATION PAR EMAIL À VENIR</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="status-footer border-top border-white-10 pt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-luxury-outline sm w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> RETRAIT DE LA SESSION
                    </button>
                </form>
                <p class="mt-4 row-sub-text opacity-30">NOTRE CONCIERGERIE VOUS RÉPONDRA SOUS 24H À 48H.</p>
            </div>
        </div>
    </div>

    <style>
        .luxury-status-container {
            min-height: 85vh;
            background: radial-gradient(circle at center, rgba(30, 41, 59, 0.4) 0%, rgba(15, 23, 42, 1) 100%);
        }

        .glass-status-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 40px;
            padding: 4rem;
            width: 100%;
            max-width: 650px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.6);
            position: relative;
            overflow: hidden;
        }

        .status-visual-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .status-icon-box {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(212, 175, 55, 0.1);
            border: 2px solid var(--luxury-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            z-index: 2;
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.2);
        }

        .waiting-rings {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 2px solid var(--luxury-gold);
            border-radius: 50%;
            opacity: 0;
            animation: statusRingExpand 3s infinite;
        }

        .ring:nth-child(2) {
            animation-delay: 1s;
        }

        .ring:nth-child(3) {
            animation-delay: 2s;
        }

        @keyframes statusRingExpand {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }

            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .premium-title {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 2.8rem;
            color: white;
        }

        .premium-subtitle {
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.35em;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .luxury-alert-item.warning {
            background: rgba(245, 158, 11, 0.05);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #fca5a5;
            padding: 1.25rem;
            border-radius: 15px;
        }

        .letter-spacing-1 {
            letter-spacing: 0.15em;
        }

        .fw-800 {
            font-weight: 800;
        }

        .btn-luxury-outline.sm {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
        }

        .btn-luxury-outline.sm:hover {
            background: white;
            color: #0f172a;
            transform: translateY(-3px);
        }

        .animate-pulse-subtle {
            animation: pulseSubtle 2s infinite ease-in-out;
        }

        @keyframes pulseSubtle {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(0.98);
            }
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

        .border-white-10 {
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        .row-sub-text {
            font-size: 0.65rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.1em;
        }
    </style>
@endsection