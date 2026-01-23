@extends('layouts.app')

@section('content')
    <div class="pending-approval-page min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="luxury-mesh"></div>

        <div class="container text-center" style="max-width: 700px; z-index: 10;">
            <div class="glass-card-luxury p-5 animate__animated animate__zoomIn">
                <div class="status-icon-wrapper mb-4">
                    <div class="hourglass-animation">
                        <i class="fas fa-hourglass-half text-gold fa-3x"></i>
                    </div>
                </div>

                <h1 class="luxury-heading-elite fs-2 mb-4">Candidature en <span class="text-gold">Examen</span></h1>

                <p class="text-white-50 fs-5 mb-5 mx-auto" style="max-width: 500px;">
                    Merci de votre intérêt pour le <strong>Défi Elite Gold</strong>. Votre profil est actuellement en cours
                    de revue par nos ambassadeurs.
                </p>

                <div class="info-box-luxury mb-5">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <i class="fas fa-shield-check text-emerald"></i>
                        <span class="small text-uppercase letter-spacing-2 fw-600">Vérification de l'admissibilité</span>
                    </div>
                </div>

                <div class="cta-group">
                    <p class="small text-white-50 mb-4">Vous recevrez un accès complet au Club Privé dès validation.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('accueil') }}" class="btn-luxury-outline px-4 py-2">
                            RETOURNER À L'ACCUEIL
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-luxury-danger px-4 py-2">
                                <i class="fas fa-sign-out-alt me-2"></i>DÉCONNEXION
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pending-approval-page {
            position: relative;
            background: #0f172a;
            color: white;
            overflow: hidden;
        }

        .luxury-mesh {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
            opacity: 0.5;
        }

        .status-icon-wrapper {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
        }

        .hourglass-animation {
            animation: rotate-hourglass 2s infinite ease-in-out;
        }

        @keyframes rotate-hourglass {
            0% {
                transform: rotate(0);
            }

            45% {
                transform: rotate(0);
            }

            55% {
                transform: rotate(180deg);
            }

            100% {
                transform: rotate(180deg);
            }
        }

        .info-box-luxury {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.1);
            padding: 15px;
            border-radius: 15px;
        }

        .btn-luxury-outline {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: transparent;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .btn-luxury-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: white;
        }

        .btn-luxury-danger {
            border: 1px solid rgba(239, 68, 68, 0.2);
            background: rgba(239, 68, 68, 0.05);
            color: #ef4444;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .btn-luxury-danger:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
        }

        .text-emerald {
            color: #10b981;
        }
    </style>
@endsection