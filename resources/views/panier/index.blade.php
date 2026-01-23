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

        .luxury-cart-wrapper {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 0% 0%, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            color: white;
            padding-top: 4rem;
            padding-bottom: 6rem;
            overflow-x: hidden;
        }

        /* Mesh Gradient Background */
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
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(212, 175, 55, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(29, 78, 216, 0.1) 0px, transparent 50%);
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .luxury-heading {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-style: italic;
            margin-bottom: 2rem;
            background: linear-gradient(to right, #fff, rgba(255, 255, 255, 0.5));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .luxury-card {
            background: var(--luxury-glass);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 35px;
            padding: 35px;
            box-shadow: 0 40px 80px -15px rgba(0, 0, 0, 0.6);
        }

        .cart-item-luxury {
            display: flex;
            align-items: center;
            gap: 30px;
            padding: 25px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .cart-item-luxury:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(10px);
            border-color: var(--luxury-gold);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.1);
        }

        .item-img-luxury {
            width: 110px;
            height: 110px;
            border-radius: 22px;
            object-fit: cover;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }

        .item-info-luxury h5 {
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
        }

        .qty-luxury {
            display: flex;
            align-items: center;
            gap: 20px;
            background: rgba(0, 0, 0, 0.3);
            padding: 10px 20px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-qty-luxury {
            background: transparent;
            border: none;
            color: white;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.5;
            transition: all 0.3s;
        }

        .btn-qty-luxury:hover {
            opacity: 1;
            color: var(--luxury-gold);
            transform: scale(1.2);
        }

        .luxury-total-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.07) 0%, rgba(255, 255, 255, 0.02) 100%);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 40px;
            padding: 45px;
            position: sticky;
            top: 120px;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.6);
        }

        .luxury-btn-primary {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #0f172a;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 22px;
            border-radius: 22px;
            border: none;
            width: 100%;
            transition: all 0.4s;
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.3);
            font-size: 0.9rem;
        }

        .luxury-btn-primary:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(212, 175, 55, 0.5);
            color: #0f172a;
        }

        .luxury-empty {
            text-align: center;
            padding: 120px 0;
        }

        .luxury-empty-icon {
            font-size: 6rem;
            margin-bottom: 2.5rem;
            background: linear-gradient(to bottom, #d4af37, transparent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0.4;
        }

        .gold-dot {
            width: 8px;
            height: 8px;
            background: var(--luxury-gold);
            border-radius: 50%;
            display: inline-block;
            margin-right: 15px;
            box-shadow: 0 0 10px var(--luxury-gold);
        }

        @media (max-width: 991px) {
            .luxury-heading {
                font-size: 2.8rem;
            }

            .cart-item-luxury {
                flex-direction: column;
                text-align: center;
                padding: 40px;
            }

            .luxury-total-card {
                position: relative;
                top: 0;
                margin-top: 3rem;
            }
        }
    </style>

    <div class="luxury-cart-wrapper">
        <div class="luxury-mesh"></div>

        <div class="container animate__animated animate__fadeIn">
            <div class="row align-items-end mb-5 pb-4">
                <div class="col-lg-8">
                    <nav class="mb-4 opacity-50">
                        <span class="small fw-700 letter-spacing-1">BOUTIQUE EXCLUSIVE <i
                                class="fas fa-chevron-right ms-2 mx-2"></i> VOTRE PANIER</span>
                    </nav>
                    <h1 class="luxury-heading">L'Art de Savourer</h1>
                    <p class="text-white-50 fw-500 mb-0 d-flex align-items-center">
                        <span class="gold-dot"></span>
                        {{ count($panier) }} sélection(s) raffinée(s) pour votre expérience gastronomique
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end d-none d-lg-block pb-3">
                    <a href="{{ route('exposants.index') }}"
                        class="btn btn-outline-light rounded-pill px-4 py-2 opacity-50 hover-opacity-100 transition-all">
                        <i class="fas fa-arrow-left me-2"></i>Explorer le Menu
                    </a>
                </div>
            </div>

            @if(count($panier) > 0)
                <div class="row g-5">
                    <div class="col-lg-8">
                        <div class="animate__animated animate__fadeInLeft">
                            @foreach($panier as $id => $item)
                                <div class="cart-item-luxury">
                                    <div class="position-relative">
                                        @if(!empty($item['photo']))
                                            <img src="{{ asset('storage/' . $item['photo']) }}" class="item-img-luxury"
                                                alt="{{ $item['nom'] }}">
                                        @else
                                            <div class="item-img-luxury bg-dark d-flex align-items-center justify-content-center">
                                                <i class="fas fa-utensils opacity-20 fa-2x"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4"
                                            style="box-shadow: inset 0 0 40px rgba(0,0,0,0.4)"></div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <span class="text-uppercase small fw-800 opacity-25 letter-spacing-2 mb-2 d-block">CHEF
                                            SELECTION</span>
                                        <h5
                                            class="text-white {{ !$item['est_disponible'] ? 'text-decoration-line-through opacity-50' : '' }}">
                                            {{ $item['nom'] }}</h5>
                                        <div class="text-white-50 small d-flex align-items-center gap-3">
                                            <span>REF: {{ str_pad($item['id'], 6, '0', STR_PAD_LEFT) }}</span>
                                            <span class="text-gold fw-bold">{{ number_format($item['prix'], 0, ',', ' ') }}
                                                FCFA</span>
                                        </div>
                                        @if(!$item['est_disponible'])
                                            <div class="text-danger small mt-2 fw-bold">
                                                <i class="fas fa-exclamation-triangle me-1"></i> RUPTURE DE STOCK - VEUILLEZ RETIRER CET
                                                ARTICLE
                                            </div>
                                        @endif
                                    </div>

                                    <div class="qty-luxury">
                                        <form action="{{ route('panier.retirer', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-qty-luxury">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </form>
                                        <span class="fw-800 fs-5 text-gold"
                                            style="min-width: 30px; text-align: center;">{{ $item['quantite'] }}</span>
                                        <form action="{{ route('panier.ajouter', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-qty-luxury">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="text-lg-end" style="min-width: 160px;">
                                        <div class="fs-3 fw-800 text-white">
                                            {{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} <span
                                                class="small fs-6 opacity-30">CFA</span>
                                        </div>
                                    </div>

                                    <form action="{{ route('panier.retirer', ['id' => $id, 'remove_all' => true]) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-link text-white-50 p-2 hover-gold hover-rotate transition-all">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="luxury-total-card animate__animated animate__fadeInRight">
                            <h3 class="fw-800 mb-5 pb-3 border-bottom border-white-10">Récapitulatif</h3>

                            <div class="d-flex justify-content-between mb-4 opacity-50">
                                <span class="fw-500">Sous-total Gastronomique</span>
                                <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                            </div>

                            <div class="d-flex justify-content-between mb-5 opacity-50">
                                <span class="fw-500">Expérience Client Luxury</span>
                                <span class="text-emerald fw-bold">Priviliégié</span>
                            </div>

                            <div class="py-5 border-top border-white-10 mb-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-4 fw-500 opacity-75">Investissement Total</span>
                                    <div class="text-end">
                                        <div class="fs-1 fw-800 text-gold lh-1">{{ number_format($total, 0, ',', ' ') }}</div>
                                        <div class="small fw-800 opacity-30 mt-1">FRANC CFA (XOF)</div>
                                    </div>
                                </div>
                            </div>

                            @php
                                $aDesIndisponibles = collect($panier)->contains('est_disponible', false);
                            @endphp

                            <div class="d-grid gap-4">
                                @if($aDesIndisponibles)
                                    <button class="luxury-btn-primary disabled" disabled style="background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.2); box-shadow: none;">
                                        SÉLECTION INDISPONIBLE
                                    </button>
                                    <p class="text-danger small text-center fw-bold">
                                        Certains articles ne sont plus en stock. Veuillez les retirer pour continuer.
                                    </p>
                                @else
                                    <a href="{{ route('commandes.create') }}" class="luxury-btn-primary text-center d-block">
                                        <i class="fas fa-check-circle me-2"></i> CONFIRMER LA SÉLECTION
                                    </a>
                                @endif
                            </div>

                            <div class="mt-5 pt-4 text-center border-top border-white-10">
                                <div class="d-flex justify-content-center gap-4 mb-3 opacity-20">
                                    <i class="fab fa-cc-visa fa-2x"></i>
                                    <i class="fab fa-cc-mastercard fa-2x"></i>
                                    <i class="fas fa-shield-alt fa-2x"></i>
                                </div>
                                <p class="small opacity-25 fw-500">Sécurisé par Eat&Drink Luxury Protocol</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="luxury-empty animate__animated animate__zoomIn">
                    <i class="fas fa-shopping-bag luxury-empty-icon"></i>
                    <h2 class="luxury-heading mb-4">Votre Collection est vide</h2>
                    <p class="text-white-50 mb-5 mx-auto fs-5 fw-300" style="max-width: 600px">
                        Laissez-vous transporter par l'excellence. Redécouvrez les créations de nos chefs partenaires et débutez
                        votre voyage culinaire.
                    </p>
                    <a href="{{ route('exposants.index') }}" class="luxury-btn-primary d-inline-block w-auto px-5 py-4">
                        COMMENCER L'EXPÉRIENCE
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .text-gold {
            color: var(--luxury-gold);
        }

        .text-emerald {
            color: var(--luxury-emerald);
        }

        .hover-gold:hover {
            color: var(--luxury-gold) !important;
        }

        .hover-rotate:hover {
            transform: rotate(90deg);
        }

        .hover-opacity-100:hover {
            opacity: 1 !important;
        }

        .border-white-10 {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        .letter-spacing-2 {
            letter-spacing: 2.5px;
        }

        .fw-800 {
            font-weight: 800;
        }

        .fw-700 {
            font-weight: 700;
        }

        .fw-500 {
            font-weight: 500;
        }

        .fw-300 {
            font-weight: 300;
        }

        .transition-all {
            transition: all 0.4s ease;
        }
    </style>
@endsection