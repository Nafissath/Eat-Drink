@extends('layouts.app')

@section('content')
<div class="luxury-confirm-page py-5 animate-fade-in">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <!-- Success Icon -->
                <div class="success-icon-wrapper mb-4 animate-scale-in">
                    <div class="outer-ring"></div>
                    <div class="inner-circle">
                        <i class="fas fa-check text-gold"></i>
                    </div>
                </div>

                <h1 class="premium-title mb-2">Confirmation <span class="text-gold">Sceau Royal</span></h1>
                <p class="premium-subtitle mb-5">VOTRE RÉSERVATION A ÉTÉ ENREGISTRÉE AVEC SUCCÈS</p>

                <div class="glass-card-luxury p-5 text-start animate-fade-up">
                    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom border-white-10 pb-4">
                        <div>
                            <div class="row-sub-text">RÉFÉRENCE DE RÉSERVATON</div>
                            <h4 class="fw-bold text-white mb-0">#{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</h4>
                        </div>
                        <div class="text-end">
                            <div class="row-sub-text">ÉTAT ACTUEL</div>
                            <span class="badge-luxury status-waiting">
                                <i class="fas fa-crown me-2"></i>En attente de traitement
                            </span>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="mini-glass-card shadow-sm">
                                <div class="row-sub-text mb-2">MODE DE RÉCEPTION</div>
                                <h6 class="fw-bold text-white mb-0 text-capitalize">
                                    {{ str_replace('_', ' ', $commande->type_commande) }}
                                    @if($commande->type_commande === 'sur_place')
                                        <span class="text-gold ms-1">Table #{{ $commande->numero_table }}</span>
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mini-glass-card shadow-sm">
                                <div class="row-sub-text mb-2">HORODATAGE</div>
                                <h6 class="fw-bold text-white mb-0">{{ $commande->created_at->format('d/m/Y H:i') }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary mb-5">
                        <h5 class="fw-bold mb-4 text-white">Composition du Panier</h5>
                        @foreach($commande->produits as $produit)
                            <div class="luxury-info-row border-white-05">
                                <span class="label text-white">{{ $produit->nom }} <small class="text-white-50 ms-2">x{{ $produit->pivot->quantite }}</small></span>
                                <span class="value">{{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 0) }} FCFA</span>
                            </div>
                        @endforeach
                        
                        <div class="total-box-luxury mt-4 p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 text-white-50 small fw-bold">VALEUR DE L'EXPÉRIENCE</h6>
                                <div class="text-white small opacity-50">Toutes taxes incluses</div>
                            </div>
                            <h2 class="fw-bold text-gold mb-0">{{ number_format($commande->total, 0) }} FCFA</h2>
                        </div>
                    </div>

                    <div class="action-grid row g-3">
                        <div class="col-md-6">
                            <a href="{{ URL::signedRoute('commandes.suivi', ['id' => $commande->id]) }}" class="btn-luxury-gold w-100 py-3">
                                <i class="fas fa-map-marker-alt me-2"></i> SUIVRE MA COMMANDE
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('accueil') }}" class="btn-luxury-outline sm w-100 py-3">
                                <i class="fas fa-shopping-bag me-2"></i> CONTINUER LA VISITE
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-5 animate-fade-in" style="animation-delay: 0.5s;">
                    <a href="{{ URL::signedRoute('commandes.telechargerRecu', ['id' => $commande->id]) }}" class="btn-luxury-link">
                        <i class="fas fa-file-pdf me-2"></i> TÉLÉCHARGER LE REÇU OFFICIEL
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .luxury-confirm-page {
        min-height: 100vh;
        background: radial-gradient(circle at 50% 0%, rgba(30, 41, 59, 0.4) 0%, rgba(15, 23, 42, 1) 100%);
    }

    .success-icon-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }

    .outer-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid var(--luxury-gold);
        border-radius: 50%;
        opacity: 0.2;
        animation: pulseRing 2s infinite;
    }

    .inner-circle {
        width: 100%;
        height: 100%;
        background: rgba(212, 175, 55, 0.1);
        border: 2px solid var(--luxury-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }

    @keyframes pulseRing {
        0% { transform: scale(1); opacity: 0.5; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    .premium-title { font-family: 'Playfair Display', serif; font-weight: 800; font-size: 3.5rem; color: white; }
    .premium-subtitle { color: rgba(255, 255, 255, 0.4); letter-spacing: 0.4em; font-size: 0.8rem; font-weight: 600; }

    .glass-card-luxury {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 30px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.5);
    }

    .row-sub-text { font-size: 0.65rem; color: rgba(255,255,255,0.4); font-weight: 800; letter-spacing: 0.15em; margin-bottom: 0.5rem; }
    .badge-luxury { padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.75rem; font-weight: 800; background: rgba(212, 175, 55, 0.1); color: var(--luxury-gold); border: 1px solid rgba(212, 175, 55, 0.3); }

    .mini-glass-card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 15px; padding: 1.25rem; }

    .luxury-info-row { display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.03); }
    .total-box-luxury { background: rgba(212, 175, 55, 0.05); border-radius: 20px; border: 1px solid rgba(212, 175, 55, 0.1); }

    .btn-luxury-gold {
        background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
        color: #0f172a;
        border: none;
        border-radius: 15px;
        font-weight: 800;
        letter-spacing: 0.05em;
        transition: all 0.3s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-luxury-gold:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3); color: #0f172a; }

    .btn-luxury-outline.sm { background: transparent; border: 1px solid rgba(255,255,255,0.1); color: white; border-radius: 15px; font-weight: 700; transition: all 0.3s; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .btn-luxury-outline.sm:hover { background: rgba(255,255,255,0.05); border-color: white; }

    .btn-luxury-link { color: var(--luxury-gold); font-weight: 800; font-size: 0.8rem; text-decoration: none; letter-spacing: 0.1em; transition: all 0.3s; }
    .btn-luxury-link:hover { color: white; }

    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
    .animate-fade-up { animation: fadeUp 0.8s backwards; }
    .animate-scale-in { animation: scaleIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275); }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes scaleIn { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
</style>
@endsection