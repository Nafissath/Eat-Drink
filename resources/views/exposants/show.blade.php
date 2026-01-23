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

        .luxury-page-wrapper {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            color: white;
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
            opacity: 0.3;
            background:
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(212, 175, 55, 0.1) 0px, transparent 50%);
        }

        .hero-luxury {
            height: 450px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: rgba(0, 0, 0, 0.4);
        }

        .hero-luxury::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.1;
        }

        .hero-luxury::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            background: linear-gradient(to top, #0f172a, transparent);
        }

        .luxury-profile-card {
            background: var(--luxury-glass);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 60px;
            padding: 80px 60px 60px;
            margin-top: -150px;
            position: relative;
            z-index: 10;
            box-shadow: 0 60px 120px -30px rgba(0, 0, 0, 0.8);
        }

        .luxury-logo-wrapper {
            width: 180px;
            height: 180px;
            background: #0f172a;
            border-radius: 50px;
            padding: 12px;
            position: absolute;
            top: -90px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
            border: 2px solid var(--luxury-gold);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .luxury-heading-main {
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            font-style: italic;
            background: linear-gradient(to right, #fff, var(--luxury-gold), #fff);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0;
            animation: shine 5s linear infinite;
        }

        @keyframes shine {
            to {
                background-position: 200% center;
            }
        }

        .luxury-product-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 45px;
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            height: 100%;
            position: relative;
        }

        .luxury-product-card:hover {
            transform: translateY(-20px) scale(1.02);
            border-color: rgba(212, 175, 55, 0.4);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
        }

        .luxury-img-container {
            height: 280px;
            position: relative;
            overflow: hidden;
        }

        .luxury-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 1.2s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .luxury-product-card:hover .luxury-img {
            transform: scale(1.15);
        }

        .luxury-price-tag {
            position: absolute;
            top: 25px;
            right: 25px;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(15px);
            color: var(--luxury-gold);
            padding: 10px 22px;
            border-radius: 20px;
            font-weight: 800;
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            z-index: 5;
        }

        .luxury-btn-add {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, #b8860b 100%);
            color: #0f172a;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            padding: 20px;
            border-radius: 22px;
            border: none;
            width: 100%;
            transition: all 0.4s;
            font-size: 0.85rem;
            position: relative;
            overflow: hidden;
        }

        .luxury-btn-add::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .luxury-btn-add:hover::before {
            left: 100%;
        }

        .luxury-btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
        }

        .section-divider {
            display: flex;
            align-items: center;
            gap: 40px;
            margin: 120px 0 70px;
        }

        .divider-line {
            height: 1px;
            flex-grow: 1;
            background: linear-gradient(to right, transparent, rgba(212, 175, 55, 0.3), transparent);
        }

        .divider-label {
            color: var(--luxury-gold);
            text-transform: uppercase;
            letter-spacing: 8px;
            font-weight: 800;
            font-size: 1rem;
            font-family: 'Outfit', sans-serif;
        }

        .grayscale {
            filter: grayscale(1) brightness(0.7) blur(2px);
            opacity: 0.6;
        }

        .luxury-sold-out-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.6);
            z-index: 2;
        }

        .badge-sold-out {
            background: #ef4444;
            color: white;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 900;
            letter-spacing: 4px;
            font-size: 0.9rem;
            box-shadow: 0 15px 30px rgba(239, 68, 68, 0.5);
            transform: rotate(-8deg);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .luxury-btn-add.disabled {
            background: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.05);
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }
    </style>

    <div class="luxury-page-wrapper">
        <div class="luxury-mesh"></div>

        <div class="hero-luxury">
            <div class="container animate__animated animate__zoomIn">
                <nav class="mb-4 opacity-40">
                    <a href="{{ route('exposants.index') }}"
                        class="text-white text-decoration-none small fw-700 letter-spacing-2 text-uppercase hover-gold transition-all">
                        <i class="fas fa-arrow-left me-2"></i> Catalogue des Exposants
                    </a>
                </nav>
                <h1 class="luxury-heading-main">{{ $exposant->nom_entreprise }}</h1>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="luxury-profile-card animate__animated animate__fadeInUp">
                        <div class="luxury-logo-wrapper">
                            <img src="{{ $exposant->logo_url }}" class="w-100 h-100 rounded-4 object-fit-contain"
                                alt="Logo">
                        </div>

                        <div class="text-center mt-5 pt-5">
                            <div class="d-flex justify-content-center gap-4 mb-5 flex-wrap">
                                <span class="badge rounded-pill px-4 py-2 fw-800"
                                    style="background: rgba(16, 185, 129, 0.1); color: var(--luxury-emerald); border: 1px solid rgba(16, 185, 129, 0.2)">
                                    <i class="fas fa-chevron-left me-2 small opacity-50"></i> ARTISAN CERTIFIÉ <i
                                        class="fas fa-chevron-right ms-2 small opacity-50"></i>
                                </span>
                                <span class="badge rounded-pill px-4 py-2 fw-800"
                                    style="background: rgba(212, 175, 55, 0.1); color: var(--luxury-gold); border: 1px solid rgba(212, 175, 55, 0.2)">
                                    <i class="fas fa-gem me-2"></i> {{ $exposant->secteur ?: 'HAUTE GASTRONOMIE' }}
                                </span>
                            </div>

                            <div class="mb-5">
                                <h3 class="text-gold small fw-800 mb-4 letter-spacing-2 text-uppercase">L'Histoire de la
                                    Maison</h3>
                                <p class="text-white fs-5 mx-auto fw-300 italic"
                                    style="max-width: 850px; line-height: 2; opacity: 0.85;">
                                    "{{ $exposant->description ?: "Plus qu'un stand, une véritable signature culinaire où chaque plat raconte une histoire de passion, de terroir et d'excellence." }}"
                                </p>
                            </div>

                            <div class="d-flex justify-content-center gap-4">
                                <a href="tel:{{ $exposant->telephone }}"
                                    class="btn btn-outline-white rounded-pill px-5 py-3 fw-700 hover-gold-bg border-opacity-25 transition-all"
                                    style="border: 1px solid white;">
                                    <i class="fas fa-phone-alt me-2"></i> RÉSERVER
                                </a>
                                <a href="mailto:{{ $exposant->email }}"
                                    class="btn btn-white rounded-pill px-5 py-3 fw-800 shadow-lg text-dark">
                                    <i class="fas fa-paper-plane me-2"></i> CONTACTER
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-divider">
                <div class="divider-line"></div>
                <span class="divider-label">La Sélection Signature</span>
                <div class="divider-line"></div>
            </div>

            @if($produits->isEmpty())
                <div class="text-center py-5 opacity-40">
                    <i class="fas fa-concierge-bell fa-4x mb-4 text-gold"></i>
                    <h3 class="fw-800">Une Nouvelle Carte en Préparation</h3>
                    <p>Le chef peaufine ses prochaines créations pour votre plaisir exclusif.</p>
                </div>
            @else
                <div class="row g-5">
                    @foreach($produits as $index => $produit)
                        <div class="col-md-6 col-lg-4 col-xl-3 animate__animated animate__fadeInUp"
                            style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="luxury-product-card d-flex flex-column">
                                <div class="luxury-img-container">
                                    <img src="{{ $produit->photo ? asset('storage/' . $produit->photo) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c' }}"
                                        class="luxury-img {{ !$produit->est_disponible ? 'grayscale' : '' }}"
                                        alt="{{ $produit->nom }}">
                                    <div class="luxury-price-tag">{{ number_format($produit->prix, 0, ',', ' ') }} <span
                                            class="small fs-6 opacity-50">CFA</span></div>

                                    @if(!$produit->est_disponible)
                                        <div class="luxury-sold-out-overlay">
                                            <span class="badge-sold-out">ÉPUISÉ</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5 d-flex flex-column flex-grow-1 text-center">
                                    <span class="text-gold small fw-800 letter-spacing-2 mb-2">SIGNATURE</span>
                                    <h4 class="fw-800 mb-3 text-white" style="font-family: 'Playfair Display', serif;">
                                        {{ $produit->nom }}</h4>
                                    <p class="text-white-50 small mb-4 flex-grow-1" style="line-height: 1.6;">
                                        {{ \Illuminate\Support\Str::limit($produit->description, 100) ?: "Une expérience gustative d'exception, alliant les produits les plus nobles à un savoir-faire artisanal." }}
                                    </p>

                                    @if($produit->est_disponible)
                                        <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="luxury-btn-add">
                                                AJOUTER AU PANIER
                                            </button>
                                        </form>
                                    @else
                                        <button class="luxury-btn-add disabled" disabled>
                                            ÉPUISÉ
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        .text-gold {
            color: var(--luxury-gold);
        }

        .text-dark {
            color: var(--luxury-dark);
        }

        .fw-800 {
            font-weight: 800;
        }

        .fw-700 {
            font-weight: 700;
        }

        .fw-300 {
            font-weight: 300;
        }

        .italic {
            font-style: italic;
        }

        .transition-all {
            transition: all 0.4s ease;
        }

        .letter-spacing-2 {
            letter-spacing: 2px;
        }

        .btn-white {
            background: white;
            color: var(--luxury-dark);
            border: none;
        }

        .btn-white:hover {
            background: var(--luxury-gold);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-white {
            border-color: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .btn-outline-white:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--luxury-gold) !important;
            color: var(--luxury-gold) !important;
        }

        .hover-gold:hover {
            color: var(--luxury-gold) !important;
        }
    </style>
@endsection