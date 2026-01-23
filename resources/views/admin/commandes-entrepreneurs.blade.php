@extends('layouts.admin')

@section('content')
<div class="luxury-dashboard animate-fade-in">
    <!-- Header -->
    <div class="header-premium mb-5">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="premium-title">
                    <span class="text-gold"><i class="fas fa-box-open me-3"></i></span>
                    Maillage <span class="text-gold">Logistique</span>
                </h1>
                <p class="premium-subtitle">Gestion centralisée des flux par ambassadeur</p>
            </div>
            <div class="col-auto">
                <span class="badge-luxury">{{ $entrepreneurs->count() }} PARTENAIRES ACTIFS</span>
            </div>
        </div>
    </div>

    <!-- Alert Status -->
    @if(session('status'))
        <div class="luxury-alert-item success mb-4 animate-fade-in">
            <i class="fas fa-check-circle me-3"></i> {{ session('status') }}
        </div>
    @endif

    <!-- Search & Filter (Visual Only for now) -->
    <div class="glass-card-luxury p-4 mb-5 animate-fade-up">
        <div class="row g-3 align-items-end">
            <div class="col-md-8">
                <label class="premium-label">RECHERCHER UN AMBASSADEUR</label>
                <div class="luxury-input-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" class="luxury-input" placeholder="Nom de l'établissement ou email...">
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn-premium-search w-100">
                    FILTRER LA LOGISTIQUE <i class="fas fa-filter ms-2"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Entrepreneurs List -->
    <div class="entrepreneurs-grid">
        @forelse($entrepreneurs as $entrepreneur)
            <div class="glass-card-luxury mb-5 overflow-hidden animate-fade-up">
                <!-- Entrepreneur Header -->
                <div class="card-header-luxury bg-gold-subtle d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="avatar-luxury">
                            {{ strtoupper(substr($entrepreneur->nom_entreprise, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">{{ $entrepreneur->nom_entreprise }}</h4>
                            <div class="row-sub-text">{{ $entrepreneur->email }}</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge-luxury shadow-glow">{{ $entrepreneur->produits->count() }} CRÉATIONS</span>
                    </div>
                </div>

                <div class="p-4 pt-0">
                    @php
                        $commandes = collect();
                        foreach($entrepreneur->produits as $produit) {
                            foreach($produit->commandes as $commande) {
                                $commandes->push($commande);
                            }
                        }
                        $commandes = $commandes->unique('id')->sortByDesc('created_at');
                    @endphp
                    
                    @if($commandes->isEmpty())
                        <div class="empty-state-luxury text-center py-5">
                            <i class="fas fa-clipboard-list text-white-50 fs-1 mb-3"></i>
                            <p class="text-white-50">Aucun mouvement transactionnel détecté.</p>
                        </div>
                    @else
                        <!-- Summary Stats for this Entrepreneur -->
                        <div class="row g-3 mb-4 mt-2">
                            <div class="col-md-6">
                                <div class="mini-glass-card shadow-sm">
                                    <div class="row-sub-text mb-1">UNITÉS TRANSACTIONNELLES</div>
                                    <h3 class="stat-value text-gold mb-0">{{ $commandes->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mini-glass-card shadow-sm">
                                    <div class="row-sub-text mb-1">VOLUME DE SORTIE</div>
                                    <h3 class="stat-value text-emerald mb-0">
                                        {{ $entrepreneur->produits->sum(function($p) { return $p->commandes->sum('pivot.quantite'); }) }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Logistical Table -->
                        <div class="luxury-table-container">
                            <table class="luxury-table">
                                <thead>
                                    <tr>
                                        <th width="120">ID FLUX</th>
                                        <th>HORODATAGE</th>
                                        <th>COMPOSITION DE LA COMMANDE</th>
                                        <th class="text-end">VALEUR NETTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commandes as $commande)
                                        <tr class="luxury-row">
                                            <td><span class="badge-luxury">#{{ $commande->id }}</span></td>
                                            <td class="row-sub-text">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="order-items-stack">
                                                    @foreach($commande->produits as $produit)
                                                        @if($produit->user_id == $entrepreneur->id)
                                                            <div class="item-pill">
                                                                <span class="text-gold fw-bold">{{ $produit->pivot->quantite }}x</span>
                                                                <span class="ms-1">{{ $produit->nom }}</span>
                                                                @if($produit->prix)
                                                                    <small class="text-white-50 ms-2">({{ number_format($produit->prix, 0) }} FCFA)</small>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $total = 0;
                                                    foreach($commande->produits as $produit) {
                                                        if($produit->user_id == $entrepreneur->id && $produit->prix && $produit->pivot && $produit->pivot->quantite) {
                                                            $total += $produit->prix * $produit->pivot->quantite;
                                                        }
                                                    }
                                                @endphp
                                                <div class="text-gold fw-bold">{{ number_format($total, 0) }} FCFA</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state-luxury text-center py-5">
                <i class="fas fa-users-slash text-white-50 fs-1 mb-4"></i>
                <h3 class="text-white">Expansion du Réseau Requise</h3>
                <p class="text-white-50">Aucun ambassadeur n'est actuellement en phase active de vente.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .premium-title { font-family: 'Playfair Display', serif; font-weight: 800; font-size: 2.5rem; }
    .premium-subtitle { color: rgba(255, 255, 255, 0.4); text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.8rem; font-weight: 600; }

    .glass-card-luxury {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
    }

    .card-header-luxury { padding: 2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
    .bg-gold-subtle { background: linear-gradient(to right, rgba(212, 175, 55, 0.05), transparent); }

    .avatar-luxury { width: 50px; height: 50px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2); color: var(--luxury-gold); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; margin-right: 1.5rem; }
    
    .mini-glass-card { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 15px; padding: 1.25rem; text-align: center; }
    .stat-value { font-weight: 800; font-size: 2rem; }
    .text-emerald { color: #10b981; }

    .luxury-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .luxury-table th { padding: 1.25rem 1.5rem; font-size: 0.7rem; font-weight: 700; color: rgba(255, 255, 255, 0.4); text-transform: uppercase; letter-spacing: 0.1em; }
    .luxury-table td { padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.03); vertical-align: middle; }

    .order-items-stack { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .item-pill { background: rgba(255,255,255,0.05); padding: 0.35rem 0.75rem; border-radius: 8px; font-size: 0.8rem; color: #fff; border: 1px solid rgba(255,255,255,0.1); }

    .badge-luxury { background: rgba(212, 175, 55, 0.15); color: var(--luxury-gold); border: 1px solid rgba(212, 175, 55, 0.3); padding: 0.4rem 1rem; border-radius: 30px; font-size: 0.7rem; font-weight: 800; }
    .shadow-glow { box-shadow: 0 0 15px rgba(212, 175, 55, 0.1); }

    .luxury-input-wrapper { position: relative; }
    .luxury-input-wrapper i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.2); }
    .luxury-input { width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 0.8rem 1rem 0.8rem 2.5rem; color: white; }

    .btn-premium-search { background: var(--luxury-gold); color: var(--luxury-dark); border: none; border-radius: 12px; padding: 0.8rem 2rem; font-weight: 800; transition: all 0.3s ease; }
    .btn-premium-search:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2); }

    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
    .animate-fade-up { animation: fadeUp 0.8s ease-out backwards; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection