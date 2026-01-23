@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap');

        :root {
            --luxury-gold: #d4af37;
            --luxury-dark: #0f172a;
            --luxury-emerald: #10b981;
            --luxury-glass: rgba(255, 255, 255, 0.03);
            --luxury-glass-border: rgba(255, 255, 255, 0.1);
        }

        .club-prive-wrapper {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            color: white;
            padding-top: 8rem;
            padding-bottom: 8rem;
            overflow-x: hidden;
        }

        .luxury-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.4;
            background:
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(212, 175, 55, 0.1) 0px, transparent 50%);
        }

        .luxury-heading-elite {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-style: italic;
            background: linear-gradient(to right, #fff, var(--luxury-gold), #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .stat-card-lux {
            background: var(--luxury-glass);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 40px;
            padding: 40px;
            text-align: center;
            transition: all 0.4s ease;
            height: 100%;
        }

        .stat-card-lux:hover {
            transform: translateY(-10px);
            border-color: var(--luxury-gold);
            background: rgba(255, 255, 255, 0.05);
        }

        .rank-badge-large {
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 25px;
            font-size: 2.5rem;
            position: relative;
        }

        .rank-badge-large::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px dashed rgba(212, 175, 55, 0.3);
            border-radius: 50%;
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            to {
                transform: rotate(360deg);
            }
        }

        .rank-gold {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #0f172a;
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.4);
        }

        .rank-silver {
            background: linear-gradient(135deg, #9ca3af 0%, #4b5563 100%);
            color: white;
            box-shadow: 0 0 30px rgba(156, 163, 175, 0.3);
        }

        .rank-bronze {
            background: linear-gradient(135deg, #cd7f32 0%, #8b4513 100%);
            color: white;
            box-shadow: 0 0 30px rgba(205, 127, 50, 0.3);
        }

        .progress-lux {
            height: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50px;
            margin: 25px 0;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .progress-bar-lux {
            background: linear-gradient(to right, var(--luxury-gold), #fff);
            border-radius: 50px;
            box-shadow: 0 0 15px var(--luxury-gold);
        }

        .exclusive-benefit {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 25px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.03);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: 0.3s;
        }

        .exclusive-benefit:hover {
            background: rgba(255, 255, 255, 0.04);
            transform: scale(1.02);
        }

        .benefit-icon {
            width: 60px;
            height: 60px;
            background: rgba(212, 175, 55, 0.1);
            color: var(--luxury-gold);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .text-gold {
            color: var(--luxury-gold);
        }

        .letter-spacing-5 {
            letter-spacing: 5px;
        }
    </style>

    <div class="club-prive-wrapper">
        <div class="luxury-mesh"></div>

        <div class="container position-relative z-index-1">
            <div class="text-center mb-5 animate__animated animate__fadeInDown">
                <span class="text-gold text-uppercase letter-spacing-5 fw-800 small d-block mb-3">L'ARENE DES
                    CHAMPIONS</span>
                <h1 class="luxury-heading-elite">Défi Elite Gold</h1>
                <p class="text-white-50 fs-5 mt-4 mx-auto" style="max-width: 700px;">
                    Bienvenue dans l'arène de l'excellence. Chaque pépite accumulée vous rapproche du trésor ultime. Jouez,
                    savourez, et dominez le classement.
                </p>
            </div>

            <div class="row g-5 mt-4">
                {{-- Carte de Statut --}}
                <div class="col-lg-5 animate__animated animate__fadeInLeft">
                    <div class="stat-card-lux">
                        <div
                            class="rank-badge-large @if(auth()->user()->rang == 'Or') rank-gold @elseif(auth()->user()->rang == 'Argent') rank-silver @else rank-bronze @endif">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h2 class="fw-800 mb-2">Joueur {{ auth()->user()->rang }}</h2>
                        <p class="text-white-50">Statut actuel dans le défi</p>

                        <div class="progress-lux">
                            @php
                                $points = auth()->user()->pepites;
                                $target = ($points < 50) ? 50 : (($points < 150) ? 150 : 500);
                                $percent = min(($points / $target) * 100, 100);
                                $nextRang = ($points < 50) ? 'Argent' : (($points < 150) ? 'Or' : 'Maître Elite');
                            @endphp
                            <div class="progress-bar-lux" style="width: {{ $percent }}%; height: 100%;"></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-start">
                                <span class="h2 fw-800 text-gold d-block mb-0">{{ $points }}</span>
                                <span class="small text-white-50 text-uppercase letter-spacing-2">Pépites Totales</span>
                            </div>
                            <div class="text-end">
                                <span class="h2 fw-800 white d-block mb-0">{{ max(0, $target - $points) }}</span>
                                <span class="small text-white-50 text-uppercase letter-spacing-2">pépites avant
                                    {{ $nextRang }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table des Récompenses --}}
                <div class="col-lg-7 animate__animated animate__fadeInRight">
                    <div class="stat-card-lux py-5 px-5">
                        <h3 class="fw-800 text-gold text-uppercase letter-spacing-2 mb-5 text-start">Table des Récompenses
                        </h3>

                        <div class="table-responsive">
                            <table class="table table-borderless text-white align-middle">
                                <thead>
                                    <tr class="border-bottom border-white border-opacity-10">
                                        <th class="pb-3 text-uppercase small letter-spacing-2 opacity-50">Rang</th>
                                        <th class="pb-3 text-uppercase small letter-spacing-2 opacity-50">Objectif</th>
                                        <th class="pb-3 text-uppercase small letter-spacing-2 opacity-50">Récompense</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-4">
                                            <span class="badge rounded-pill bg-bronze-luxury px-3 py-2">BRONZE</span>
                                        </td>
                                        <td class="py-4">Inscrit</td>
                                        <td class="py-4 text-white-50 small italic">Droit d'entrée au jeu, badges de base.
                                        </td>
                                    </tr>
                                    <tr class="border-top border-white border-opacity-5">
                                        <td class="py-4">
                                            <span class="badge rounded-pill bg-silver-luxury px-3 py-2">ARGENT</span>
                                        </td>
                                        <td class="py-4">50 Pépites</td>
                                        <td class="py-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-ticket-alt text-gold me-2"></i>
                                                <span>Cocktail de bienvenue offert</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-top border-white border-opacity-5">
                                        <td class="py-4">
                                            <span class="badge rounded-pill bg-gold-luxury px-3 py-2">OR</span>
                                        </td>
                                        <td class="py-4">150 Pépites</td>
                                        <td class="py-4">
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="fas fa-star text-gold me-2"></i>
                                                    <span>Table VIP Prioritaire</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-percentage text-gold me-2"></i>
                                                    <span class="small">Remise de 10% sur tout l'événement</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5 pt-3 border-top border-white border-opacity-10 text-start">
                            <p class="text-white-50 small mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Gagnez 1 Pépite pour chaque tranche de 1000 FCFA dépensée. Les récompenses sont débloquées
                                automatiquement dès l'atteinte du seuil.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Règles du Jeu --}}
            <div class="row mt-5 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="col-12">
                    <div class="stat-card-lux p-5 text-start">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="fw-800 text-gold mb-3">1. Commandez</h4>
                                <p class="text-white-50 small">Parcourez les menus de nos exposants d'exception et passez
                                    commande en ligne.</p>
                            </div>
                            <div class="col-md-4">
                                <h4 class="fw-800 text-gold mb-3">2. Accumulez</h4>
                                <p class="text-white-50 small">Chaque FCFA dépensé vous rapporte des Pépites. Plus vous
                                    savourez, plus vous gagnez.</p>
                            </div>
                            <div class="col-md-4">
                                <h4 class="fw-800 text-gold mb-3">3. Triomphez</h4>
                                <p class="text-white-50 small">Débloquez des privilèges de plus en plus prestigieux et
                                    inscrivez votre nom au Panthéon.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection