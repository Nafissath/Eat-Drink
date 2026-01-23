@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #7b1e3d;">Commandes Reçues</h2>
            <div class="text-muted">Suivi des commandes clients.</div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-bg-light">{{ $commandes->count() }} commande(s)</span>
        </div>
    </div>

    @if($commandes->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                <div class="mb-3" style="font-size: 2rem; color: #7b1e3d;"><i class="fas fa-inbox"></i></div>
                <h5 class="fw-bold">Aucune commande</h5>
                <p class="text-muted mb-0">Les commandes reçues apparaîtront ici dès qu'un client passera commande.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Commande #</th>
                        <th>Produits</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commandes as $commande)
                        <tr>
                            <td class="text-center">#{{ $commande->id }}</td>
                            <td>
                                @foreach($commande->produits as $produit)
                                    {{ $produit->nom }} (x{{ $produit->pivot->quantite }})<br>
                                @endforeach
                            </td>
                            <td class="text-center">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <span class="badge 
                                    @if($commande->statut === 'annulee') bg-danger
                                    @elseif($commande->statut === 'terminee') bg-success
                                    @elseif($commande->statut === 'en_preparation') bg-warning
                                    @else bg-info @endif">
                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-sm btn-primary" title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $commandes->links() }}
        </div>
    @endif
</div>
@endsection
