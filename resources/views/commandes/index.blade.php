@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');
    
    .orders-history-page {
        font-family: 'Outfit', sans-serif;
        background: #f8fafc;
        min-height: 100vh;
    }

    .page-title {
        background: linear-gradient(135deg, #7b1e3d 0%, #b02a57 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .order-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .order-header {
        padding: 20px;
        background: #fdfdfd;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-pill {
        padding: 6px 14px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-en_attente { background: #e0f2fe; color: #0369a1; }
    .status-en_preparation { background: #fef3c7; color: #92400e; }
    .status-prete { background: #dcfce7; color: #166534; }
    .status-terminee { background: #f1f5f9; color: #475569; }
    .status-annulee { background: #fee2e2; color: #991b1b; }

    .product-thumb {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .btn-action {
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        color: #94a3b8;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
</style>

<div class="orders-history-page py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h1 class="page-title mb-1">Mes Commandes</h1>
                <p class="text-muted mb-0">Historique et suivi de vos consommations</p>
            </div>
            <div class="d-none d-md-block">
                <span class="badge bg-white shadow-sm text-dark px-3 py-2 rounded-pill fw-bold">
                    {{ $commandes->count() }} commande(s)
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 text-center py-3 mb-4">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @forelse($commandes as $commande)
            <div class="order-card mb-4 animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="order-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block mb-0">Commande #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="fw-bold fs-5">{{ $commande->created_at->translatedFormat('d F Y') }} <small class="text-muted fw-normal ms-1">{{ $commande->created_at->format('H:i') }}</small></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="status-pill status-{{ $commande->statut }}">
                            <i class="fas fa-circle me-1 small"></i> {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                        <h5 class="fw-bold mb-0 text-primary">{{ number_format($commande->total, 0, ',', ' ') }} <small class="fs-6">FCFA</small></h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center gap-2 overflow-auto pb-2">
                                @foreach($commande->produits as $produit)
                                    <div class="position-relative me-2" title="{{ $produit->nom }} x{{ $produit->pivot->quantite }}">
                                        @if($produit->photo)
                                            <img src="{{ asset('storage/' . $produit->photo) }}" class="product-thumb" alt="{{ $produit->nom }}">
                                        @else
                                            <div class="product-thumb bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-utensils text-muted opacity-25"></i>
                                            </div>
                                        @endif
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark border border-white" style="font-size: 0.65rem;">
                                            {{ $produit->pivot->quantite }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                                <a href="{{ URL::signedRoute('commandes.suivi', ['id' => $commande->id]) }}" class="btn btn-action btn-primary">
                                    <i class="fas fa-eye me-1"></i> Détails
                                </a>
                                @if($commande->statut === 'en_attente')
                                    <form action="{{ route('commandes.annuler', $commande->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-action btn-outline-danger" onclick="return confirm('Souhaitez-vous annuler cette commande ?')">
                                            Annuler
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                        <div class="small">
                            <span class="text-muted"><i class="fas fa-info-circle me-1"></i> {{ ucfirst(str_replace('_', ' ', $commande->type_commande)) }}</span>
                            @if($commande->type_commande === 'sur_place')
                                <span class="badge bg-light text-dark ms-2 fw-normal">Table #{{ $commande->numero_table }}</span>
                            @endif
                        </div>
                        <div class="small text-muted">
                            {{ $commande->produits->sum('pivot.quantite') }} article(s) au total
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state card border-0 shadow-sm animate__animated animate__zoomIn">
                <div class="empty-icon">
                    <i class="fas fa-shopping-basket fa-4x"></i>
                </div>
                <h3 class="fw-bold mb-3">Aucune commande trouvée</h3>
                <p class="text-muted mb-4 px-md-5">Il semble que vous n'ayez pas encore passé de commande. Découvrez nos exposants et savourez nos plats !</p>
                <a href="{{ route('exposants.index') }}" class="btn btn-premium btn-premium-primary px-5 py-3 rounded-pill">
                    <i class="fas fa-store me-2"></i>Explorer le catalogue
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

