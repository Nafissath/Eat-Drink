@extends('layouts.app')

@section('content')
    <div class="luxury-dashboard py-5 animate-fade-in">
        <div class="container">
            <!-- Header -->
            <div class="header-premium mb-5 text-center">
                <h1 class="premium-title">Vos <span class="text-gold">Réservations</span></h1>
                <p class="premium-subtitle">HISTORIQUE DE VOS EXPÉRIENCES GASTRONOMIQUES</p>
            </div>

            @if(empty($commandes) || $commandes->isEmpty())
                <div class="glass-card-luxury p-5 text-center animate-fade-up">
                    <i class="fas fa-history text-white-50 fs-1 mb-4"></i>
                    <h4 class="text-white">Le silence est d'or</h4>
                    <p class="text-white-50">Vous n'avez pas encore de commandes enregistrées dans notre domaine.</p>
                    <a href="{{ route('exposants.index') }}" class="btn-luxury-gold mt-3 d-inline-block">DÉCOUVRIR LA CARTE</a>
                </div>
            @else
                <div class="row g-4 animate-fade-up">
                    @foreach($commandes as $commande)
                        <div class="col-md-6 col-lg-4">
                            <div class="glass-card-luxury p-4 h-100 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <div class="row-sub-text mb-1">RÉFÉRENCE</div>
                                        <h4 class="fw-bold text-white">#{{ $commande->id }}</h4>
                                    </div>
                                    <span class="badge-luxury {{ $commande->statut }}">
                                        {{ strtoupper(str_replace('_', ' ', $commande->statut)) }}
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <div class="luxury-info-row">
                                        <span class="label">DATE</span>
                                        <span class="value">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="luxury-info-row">
                                        <span class="label">TYPE</span>
                                        <span class="value">{{ strtoupper($commande->type_commande) }}</span>
                                    </div>
                                    <div class="luxury-info-row">
                                        <span class="label">MONTANT</span>
                                        <span class="value text-gold">{{ number_format($commande->total, 0) }} FCFA</span>
                                    </div>
                                </div>

                                <div class="mt-auto pt-3 border-top border-white-10">
                                    <a href="{{ URL::signedRoute('commandes.suivi', ['id' => $commande->id]) }}"
                                        class="btn-luxury-link w-100 text-center {{ !in_array($commande->statut, ['terminee', 'annulee']) ? 'active-track' : '' }}">
                                        @if(!in_array($commande->statut, ['terminee', 'annulee']))
                                            <span class="pulse-icon-mini"></span>
                                            SUIVRE EN TEMPS RÉEL
                                        @else
                                            VOIR LES DÉTAILS
                                        @endif
                                        <i class="fas fa-arrow-right ms-2 mt-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        .luxury-dashboard {
            min-height: 80vh;
            background: radial-gradient(circle at 50% 0%, rgba(30, 41, 59, 0.4) 0%, rgba(15, 23, 42, 1) 100%);
        }

        .premium-title {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 2.5rem;
            color: white;
        }

        .premium-subtitle {
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.3em;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .glass-card-luxury {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card-luxury:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .row-sub-text {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 800;
            letter-spacing: 0.1em;
        }

        .badge-luxury {
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .badge-luxury.en_attente {
            background: rgba(245, 158, 11, 0.15);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .badge-luxury.prete,
        .badge-luxury.terminee {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .badge-luxury.annulee {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .luxury-info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.85rem;
        }

        .luxury-info-row .label {
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
        }

        .luxury-info-row .value {
            color: white;
            font-weight: 700;
        }

        .border-white-10 {
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        .btn-luxury-link {
            display: block;
            color: var(--luxury-gold);
            font-weight: 800;
            font-size: 0.75rem;
            text-decoration: none;
            letter-spacing: 0.1em;
            transition: all 0.3s;
        }

        .btn-luxury-link:hover {
            color: white;
            letter-spacing: 0.15em;
        }

        .active-track {
            color: var(--luxury-gold) !important;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 12px;
            padding: 8px 0;
            background: rgba(212, 175, 55, 0.05);
        }

        .pulse-icon-mini {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            margin-right: 8px;
            box-shadow: 0 0 10px #10b981;
            animation: pulseMini 2s infinite;
        }

        @keyframes pulseMini {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.3);
                opacity: 0.5;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
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
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection