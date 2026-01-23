{{-- resources/views/entrepreneur/produits/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --luxury-gold: #d4af37;
            --luxury-dark: #0f172a;
            --luxury-glass: rgba(255, 255, 255, 0.03);
            --luxury-glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            color: white;
            min-height: 100vh;
        }

        .page-header-lux {
            padding: 4rem 0;
            position: relative;
        }

        /* Stats Bar Luxury */
        .stats-grid-lux {
            background: var(--luxury-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 30px;
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .stat-item-lux {
            text-align: center;
            border-right: 1px solid var(--luxury-glass-border);
        }

        .stat-item-lux:last-child {
            border-right: none;
        }

        /* Product Cards LUX */
        .product-card-lux {
            background: var(--luxury-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 25px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
        }

        .product-card-lux:hover {
            transform: translateY(-10px);
            border-color: var(--luxury-gold);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .product-img-lux {
            height: 250px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .product-card-lux:hover .product-img-lux {
            transform: scale(1.1);
        }

        .luxury-badge-price {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            color: var(--luxury-gold);
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 800;
            border: 1px solid var(--luxury-gold);
            z-index: 2;
        }

        .card-actions-lux {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .product-card-lux:hover .card-actions-lux {
            opacity: 1;
            transform: translateX(0);
        }

        .btn-action-round {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: var(--luxury-dark);
            border: none;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-action-round:hover {
            background: var(--luxury-gold);
            color: white;
            transform: scale(1.1);
        }

        .btn-delete-lux {
            background: #ef4444;
            color: white;
        }

        /* Status Badges */
        .status-pill {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-pill.online {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-pill.offline {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-plus-lux {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 800;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        .btn-plus-lux:hover {
            transform: translateY(-3px);
            filter: brightness(1.1);
            color: var(--luxury-dark);
        }

        .animate-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
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
@endpush

@section('content')
    <div class="container pb-5">
        <!-- Header -->
        <div class="page-header-lux animate-up">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('entrepreneur.dashboard') }}"
                                    class="text-white-50 text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active text-gold" aria-current="page">Mon Catalogue</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 fw-800" style="font-family: 'Playfair Display', serif;">Gestion du Menu</h1>
                    <p class="text-white-50">Sublimez vos créations et gérez vos disponibilités en temps réel.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-plus-lux">
                        <i class="fas fa-plus me-2"></i>NOUVEAUTÉ
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid-lux animate-up" style="animation-delay: 0.1s;">
            <div class="row">
                <div class="col-md-4 stat-item-lux">
                    <div class="text-white-50 small text-uppercase letter-spacing-2 mb-1">Total Créations</div>
                    <div class="h2 fw-800 mb-0">{{ $produits->count() }}</div>
                </div>
                <div class="col-md-4 stat-item-lux">
                    <div class="text-white-50 small text-uppercase letter-spacing-2 mb-1">Valeur Menu</div>
                    <div class="h2 fw-800 mb-0 text-gold">{{ number_format($produits->sum('prix'), 0, ',', ' ') }} <span
                            class="fs-6 opacity-50">CFA</span></div>
                </div>
                <div class="col-md-4 stat-item-lux">
                    <div class="text-white-50 small text-uppercase letter-spacing-2 mb-1">Actuellement en Vente</div>
                    <div class="h2 fw-800 mb-0 text-success">{{ $produits->where('est_disponible', true)->count() }}</div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert bg-success bg-opacity-10 border-success border-opacity-25 text-success rounded-4 mb-5 animate-up">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($produits->isEmpty())
            <div class="content-box-lux text-center py-5 opacity-50 animate-up">
                <i class="fas fa-utensils fa-4x mb-4 text-white-50"></i>
                <h4 class="fw-800">Votre carte est vierge</h4>
                <p>Il est temps de partager vos saveurs avec le monde.</p>
                <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-plus-lux mt-3">AJOUTER MON PREMIER PLAT</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($produits as $index => $produit)
                    <div class="col-md-6 col-lg-4 animate-up" style="animation-delay: {{ 0.2 + ($index * 0.05) }}s;">
                        <div class="product-card-lux">
                            <div class="luxury-badge-price">
                                {{ number_format($produit->prix, 0, ',', ' ') }} <span class="small opacity-75">CFA</span>
                            </div>

                            <div class="card-actions-lux">
                                <a href="{{ route('entrepreneur.produits.edit', $produit) }}" class="btn-action-round"
                                    title="Éditer">
                                    <i class="fas fa-pen small"></i>
                                </a>
                                <button type="button" class="btn-action-round btn-delete-lux" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $produit->id }}" title="Supprimer">
                                    <i class="fas fa-trash small"></i>
                                </button>
                            </div>

                            <div class="position-relative overflow-hidden">
                                @if($produit->photo)
                                    <img src="{{ asset('storage/' . $produit->photo) }}" class="product-img-lux"
                                        alt="{{ $produit->nom }}">
                                @else
                                    <div class="product-img-lux d-flex align-items-center justify-content-center bg-dark">
                                        <i class="fas fa-image fa-3x opacity-10"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="fw-800 mb-0 text-white">{{ $produit->nom }}</h5>
                                    <div class="status-pill {{ $produit->est_disponible ? 'online' : 'offline' }}">
                                        {{ $produit->est_disponible ? 'Disponible' : 'Épuisé' }}
                                    </div>
                                </div>

                                <p class="text-white-50 small mb-4"
                                    style="height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    {{ $produit->description }}
                                </p>

                                <form action="{{ route('entrepreneur.produits.toggle', $produit->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn w-100 rounded-pill fw-800 py-2 fs-7 {{ $produit->est_disponible ? 'btn-outline-danger' : 'btn-success' }}"
                                        style="font-size: 0.75rem;">
                                        <i
                                            class="fas {{ $produit->est_disponible ? 'fa-minus-circle' : 'fa-check-circle' }} me-2"></i>
                                        {{ $produit->est_disponible ? 'MARQUER ÉPUISÉ' : 'REMETTRE EN STOCK' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $produit->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark border-0 shadow-lg rounded-4 overflow-hidden"
                                style="border: 1px solid var(--luxury-glass-border) !important;">
                                <div class="p-5 text-center">
                                    <div class="mb-4">
                                        <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-circle"
                                            style="width: 80px; height: 80px;">
                                            <i class="fas fa-trash-alt text-danger fa-2x"></i>
                                        </div>
                                    </div>
                                    <h4 class="fw-800 mb-3 text-white">Retirer du catalogue ?</h4>
                                    <p class="text-white-50 mb-4">La suppression de <span
                                            class="text-white fw-800">"{{ $produit->nom }}"</span> est définitive. Confirmez-vous ce
                                        choix ?</p>
                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-outline-light rounded-pill px-4 fw-800"
                                            data-bs-dismiss="modal">ANNULER</button>
                                        <form action="{{ route('entrepreneur.produits.destroy', $produit) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-800">OUI,
                                                SUPPRIMER</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection