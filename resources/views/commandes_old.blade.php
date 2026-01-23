@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-center" style="color: #7b1e3d;">Commandes Reçues</h2>

    @if($commandes->isEmpty())
        <p class="text-muted text-center">Aucune commande reçue pour le moment.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
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
        
        <div class="d-flex justify-content-center mt-4">
            {{ $commandes->links() }}
        </div>
    @endif
</div>
@endsection
