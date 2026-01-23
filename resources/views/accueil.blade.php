@extends('layouts.app')

@section('content')
    <div class="luxury-home-page">
        <!-- Hero Section with Parallax -->
        <section class="hero-luxury">
            <div class="hero-overlay"></div>
            <div class="hero-bg"
                style="background-image: url('{{ asset('brain/54bbe748-1c48-45d6-bfa0-11e2d4ed500a/luxury_hero_food_image_1769136073735.png') }}');">
            </div>

            <div class="container hero-content">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-8 text-center text-lg-start animate-fade-up">
                        <span class="badge-premium mb-3">L'EXPÉRIENCE GASTRONOMIQUE ULTIME</span>
                        <h1 class="display-1 hero-title mb-4">
                            Savourez l'Excellence <br>
                            <span class="text-gold">Eat&Drink</span>
                        </h1>
                        <p class="hero-lead mb-5">
                            Découvrez une sélection exclusive des meilleurs établissements culinaires de Cotonou.
                            Commandez, dégustez, et vivez l'exceptionnel.
                        </p>
                        <div class="hero-btns gap-3">
                            <a href="{{ route('exposants.index') }}" class="btn-luxury-primary">
                                <span class="btn-text">DÉCOUVRIR LE CATALOGUE</span>
                                <i class="fas fa-arrow-right ms-2 transition-icon"></i>
                            </a>
                            <a href="{{ route('panier') }}" class="btn-luxury-outline">
                                <i class="fas fa-shopping-bag me-2"></i>
                                MON PANIER
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-scroll-indicator">
                <div class="mouse"></div>
                <p>DÉCOUVRIR PLUS</p>
            </div>
        </section>

        @auth
            @if($activeOrder = Auth::user()->getActiveOrder())
                <section class="live-tracking-widget py-4 animate-fade-in">
                    <div class="container">
                        <div class="glass-card-luxury p-4 border-gold-glow shadow-gold">
                            <div class="row align-items-center">
                                <div class="col-lg-1 col-md-2 text-center text-md-start mb-3 mb-md-0">
                                    <div class="status-icon-pulse">
                                        <i class="fas fa-utensils text-gold fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-10 mb-3 mb-md-0">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <span class="badge bg-gold-luxury text-dark fw-800 px-3">EN COURS</span>
                                        <span class="text-white-50 small">Commande #{{ $activeOrder->id }}</span>
                                    </div>
                                    <h4 class="text-white fw-bold mb-0">Votre commande est en préparation...</h4>
                                    <p class="text-white-50 small mb-0">Réf : {{ strtoupper($activeOrder->type_commande) }} •
                                        Dernière mise à jour à {{ $activeOrder->updated_at->format('H:i') }}</p>
                                </div>
                                <div class="col-lg-4 col-md-8 mb-3 mb-md-0">
                                    <div class="mini-progress-track">
                                        <div class="mini-progress-bar"
                                            style="width: {{ $activeOrder->statut === 'en_preparation' ? '40%' : ($activeOrder->statut === 'prete' ? '70%' : '15%') }}">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-gold tiny-text fw-800">PRÉPARATION</span>
                                        <span class="text-white-50 tiny-text">LIVRAISON</span>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 text-center text-lg-end">
                                    <a href="{{ URL::signedRoute('commandes.suivi', ['id' => $activeOrder->id]) }}"
                                        class="btn-luxury-gold sm py-2 px-4 rounded-pill">
                                        SUIVRE <i class="fas fa-external-link-alt ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <style>
                    .border-gold-glow {
                        border: 1px solid rgba(212, 175, 55, 0.4);
                    }

                    .shadow-gold {
                        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.1);
                    }

                    .status-icon-pulse {
                        width: 60px;
                        height: 60px;
                        background: rgba(212, 175, 55, 0.1);
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0 auto;
                        animation: pulseLuxury 2s infinite;
                    }

                    @keyframes pulseLuxury {
                        0% {
                            transform: scale(1);
                            box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4);
                        }

                        70% {
                            transform: scale(1.05);
                            box-shadow: 0 0 0 10px rgba(212, 175, 55, 0);
                        }

                        100% {
                            transform: scale(1);
                            box-shadow: 0 0 0 0 rgba(212, 175, 55, 0);
                        }
                    }

                    .mini-progress-track {
                        height: 6px;
                        background: rgba(255, 255, 255, 0.1);
                        border-radius: 10px;
                        overflow: hidden;
                        position: relative;
                    }

                    .mini-progress-bar {
                        height: 100%;
                        background: linear-gradient(to right, #d4af37, #f1c40f);
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
                    }

                    .tiny-text {
                        font-size: 0.6rem;
                        letter-spacing: 1px;
                    }
                </style>
            @endif
        @endauth

        <!-- Navigation Cards Section -->
        <section class="nav-cards-section py-5">
            <div class="container py-5">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4 animate-on-scroll">
                        <a href="{{ route('auth.inscription') }}" class="card-link-wrapper">
                            <div class="glass-card-luxury h-100 p-5 text-center">
                                <div class="card-icon-wrapper mb-4">
                                    <i class="fas fa-chef-hat text-emerald"></i>
                                </div>
                                <h3 class="card-title-luxury">Entrepreneurs</h3>
                                <p class="card-text-luxury">Rejoignez notre réseau d'élite et propulsez votre établissement
                                    vers de nouveaux sommets.</p>
                                <span class="card-action-text">DEVENIR PARTENAIRE <i
                                        class="fas fa-chevron-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 animate-on-scroll" style="transition-delay: 0.1s;">
                        <a href="{{ route('exposants.index') }}" class="card-link-wrapper">
                            <div class="glass-card-luxury h-100 p-5 text-center active-focus">
                                <div class="card-icon-wrapper mb-4">
                                    <i class="fas fa-users text-gold"></i>
                                </div>
                                <h3 class="card-title-luxury">Visiteurs</h3>
                                <p class="card-text-luxury">Explorez les saveurs authentiques et les créations uniques de
                                    nos chefs sélectionnés.</p>
                                <span class="card-action-text">PARCOURIR LES STANDS <i
                                        class="fas fa-chevron-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 animate-on-scroll" style="transition-delay: 0.2s;">
                        <a href="{{ route('panier') }}" class="card-link-wrapper">
                            <div class="glass-card-luxury h-100 p-5 text-center">
                                <div class="card-icon-wrapper mb-4">
                                    <i class="fas fa-shopping-cart text-white"></i>
                                </div>
                                <h3 class="card-title-luxury">Commandes</h3>
                                <p class="card-text-luxury">Une gestion fluide et sécurisée de vos sélections gastronomiques
                                    préférées.</p>
                                <span class="card-action-text">GÉRER MES ACHATS <i
                                        class="fas fa-chevron-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Us Section -->
        <section class="features-section py-5">
            <div class="container py-5">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-6 text-center">
                        <h2 class="section-title-luxury">Pourquoi <span class="text-gold">Eat&Drink</span> ?</h2>
                        <div class="title-underline"></div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-md-4 text-center">
                        <div class="feature-item p-4">
                            <div class="feature-icon mb-4"><i class="fas fa-gem"></i></div>
                            <h4 class="feature-title mb-3">Qualité Premium</h4>
                            <p class="feature-desc">Une sélection rigoureuse des meilleurs exposants pour une expérience
                                culinaire sans compromis.</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="feature-item p-4">
                            <div class="feature-icon mb-4"><i class="fas fa-bolt"></i></div>
                            <h4 class="feature-title mb-3">Rapidité & Simplicité</h4>
                            <p class="feature-desc">Un parcours utilisateur fluide, de la découverte à la livraison, pensé
                                pour votre confort.</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="feature-item p-4">
                            <div class="feature-icon mb-4"><i class="fas fa-shield-check"></i></div>
                            <h4 class="feature-title mb-3">Engagement Local</h4>
                            <p class="feature-desc">Soutenez les talents de Cotonou à travers une plateforme qui valorise le
                                savoir-faire béninois.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Elite Gold Game Section -->
        <section class="elite-game-section py-5">
            <div class="container py-5">
                <div class="glass-card-luxury p-0 overflow-hidden border-gold-glow animate-on-scroll">
                    <div class="row g-0">
                        <div class="col-lg-6 p-5 d-flex flex-column justify-content-center">
                            <span class="badge-premium mb-4">NOUVEAU : LE JEU ÉVÉNEMENT</span>
                            <h2 class="display-4 fw-800 mb-4" style="font-family: 'Playfair Display', serif;">
                                Relevez le Défi <br> <span class="text-gold">Elite Gold</span>
                            </h2>
                            <p class="fs-5 text-white-50 mb-5 fw-300" style="line-height: 1.8;">
                                Transformez vos dégustations en une quête légendaire. Cumulez des **Pépites** à chaque
                                commande, grimpez les rangs et débloquez des coffres de récompenses exclusifs.
                            </p>

                            <div class="d-flex flex-column gap-4 mb-5">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="mini-icon-box gold"><i class="fas fa-trophy"></i></div>
                                    <div class="fw-600">Gagnez des prix réels et des invitations VIP</div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="mini-icon-box emerald"><i class="fas fa-user-plus"></i></div>
                                    <div class="fw-600">Compte obligatoire pour participer au jeu</div>
                                </div>
                            </div>

                            @guest
                                <a href="{{ route('auth.inscription-defi') }}"
                                    class="btn-luxury-gold py-3 px-5 d-inline-block text-center rounded-pill fw-800">
                                    CRÉER MON COMPTE ET JOUER
                                </a>
                            @else
                                <a href="{{ route('client.club-prive') }}"
                                    class="btn-luxury-gold py-3 px-5 d-inline-block text-center rounded-pill fw-800">
                                    VOIR MON SCORE DE JEU
                                </a>
                            @endguest
                        </div>
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="game-visual-wrapper h-100">
                                <div class="floating-presents">
                                    <i class="fas fa-gem gem-1"></i>
                                    <i class="fas fa-crown crown-1"></i>
                                    <i class="fas fa-coins coins-1"></i>
                                </div>
                                <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=2070&auto=format&fit=crop"
                                    class="h-100 w-100 object-fit-cover"
                                    style="filter: brightness(0.4) sepia(0.3) saturate(1.5);" alt="Elite Game">
                                <div class="game-overlay-gradient"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .luxury-home-page {
            background: #0f172a;
            color: white;
            font-family: 'Outfit', sans-serif;
        }

        /* Hero Styling */
        .hero-luxury {
            position: relative;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            transition: transform 0.5s ease;
            z-index: 1;
        }

        .hero-luxury:hover .hero-bg {
            transform: scale(1.05);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #0f172ad0 0%, #0f172a90 50%, #0f172a10 100%);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .badge-premium {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: rgba(212, 175, 55, 0.15);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: #d4af37;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.3em;
            border-radius: 5px;
            text-transform: uppercase;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.01em;
        }

        .text-gold {
            background: linear-gradient(135deg, #d4af37 0%, #f1c40f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-lead {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.7);
            max-width: 650px;
            font-weight: 300;
            line-height: 1.6;
        }

        /* Buttons */
        .btn-luxury-primary {
            display: inline-block;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1.1rem 2.5rem;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 35px -10px rgba(16, 185, 129, 0.5);
        }

        .btn-luxury-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px -10px rgba(16, 185, 129, 0.6);
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: white;
        }

        .btn-luxury-outline {
            display: inline-block;
            padding: 1.1rem 2.5rem;
            border: 2px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-decoration: none;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-luxury-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: #d4af37;
            color: #d4af37;
        }

        /* Scroll Indicator */
        .hero-scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            text-align: center;
            opacity: 0.7;
        }

        .hero-scroll-indicator p {
            font-size: 0.65rem;
            letter-spacing: 0.4em;
            margin-top: 15px;
            font-weight: 600;
        }

        .mouse {
            width: 26px;
            height: 42px;
            border: 2px solid white;
            border-radius: 20px;
            margin: 0 auto;
            position: relative;
        }

        .mouse:before {
            content: '';
            width: 4px;
            height: 8px;
            background: white;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
            animation: scrollWheel 2s infinite;
        }

        @keyframes scrollWheel {
            0% {
                opacity: 1;
                top: 8px;
            }

            100% {
                opacity: 0;
                top: 25px;
            }
        }

        /* Glass Cards */
        .card-link-wrapper {
            text-decoration: none !important;
            display: block;
            height: 100%;
        }

        .glass-card-luxury {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 2rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .glass-card-luxury:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-15px);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.6);
        }

        .active-focus {
            border-color: rgba(212, 175, 55, 0.3);
            box-shadow: 0 20px 40px -10px rgba(212, 175, 55, 0.1);
        }

        .card-icon-wrapper {
            font-size: 3rem;
            margin-bottom: 2rem;
            transition: transform 0.5s ease;
        }

        .glass-card-luxury:hover .card-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .card-title-luxury {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
        }

        .card-text-luxury {
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .card-action-text {
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.15em;
            color: #d4af37;
            transition: all 0.3s ease;
        }

        .glass-card-luxury:hover .card-action-text {
            letter-spacing: 0.25em;
        }

        /* Section Title */
        .section-title-luxury {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .title-underline {
            width: 80px;
            height: 4px;
            background: #d4af37;
            margin: 0 auto;
            border-radius: 2px;
        }

        /* Features */
        .feature-item {
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: scale(1.05);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #d4af37;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .feature-title {
            font-weight: 700;
            font-size: 1.4rem;
        }

        .feature-desc {
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }

        /* Animations */
        .animate-fade-up {
            animation: fadeUp 1s ease-out forwards;
        }

        /* Elite Game Styling */
        .elite-game-section {
            background: rgba(0, 0, 0, 0.2);
        }

        .border-gold-glow {
            border: 1px solid rgba(212, 175, 55, 0.4) !important;
            box-shadow: 0 0 50px rgba(212, 175, 55, 0.1);
        }

        .mini-icon-box {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .mini-icon-box.gold {
            background: rgba(212, 175, 55, 0.1);
            color: #d4af37;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .mini-icon-box.emerald {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .btn-luxury-gold {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #0f172a;
            text-decoration: none;
            transition: all 0.4s;
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.2);
        }

        .btn-luxury-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.4);
            color: #0f172a;
        }

        .fw-800 {
            font-weight: 800;
        }

        .game-visual-wrapper {
            position: relative;
            overflow: hidden;
        }

        .game-overlay-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #0f172a 0%, transparent 100%);
        }

        .floating-presents {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 5;
            pointer-events: none;
        }

        .floating-presents i {
            position: absolute;
            color: var(--luxury-gold);
            opacity: 0.6;
            filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.5));
        }

        .gem-1 {
            top: 20%;
            right: 20%;
            font-size: 3rem;
            animation: float 6s infinite ease-in-out;
        }

        .crown-1 {
            bottom: 30%;
            right: 40%;
            font-size: 4rem;
            animation: float 8s infinite ease-in-out;
        }

        .coins-1 {
            top: 40%;
            right: 25%;
            font-size: 2.5rem;
            animation: float 7s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0);
            }

            50% {
                transform: translateY(-30px) rotate(10deg);
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
@endsection