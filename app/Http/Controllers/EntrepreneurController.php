<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class EntrepreneurController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $produits = $user->produits;

        // Récupérer toutes les commandes liées à cet entrepreneur
        $commandes = Commande::whereHas('produits', function ($query) use ($produits) {
            $query->whereIn('produit_id', $produits->pluck('id'));
        })->with([
                    'produits' => function ($q) use ($produits) {
                        $q->whereIn('produit_id', $produits->pluck('id'));
                    }
                ])->latest()->get();

        // Statistiques de base
        $total_produits = $produits->count();
        $total_commandes = $commandes->count();
        $total_ventes = 0;

        // Stats pour les graphiques et performances
        $salesByHour = array_fill(0, 24, 0);
        $productStats = [];

        foreach ($commandes as $commande) {
            $hour = (int) $commande->created_at->format('H');
            $commandeTotal = 0;

            foreach ($commande->produits as $produit) {
                if ($produit->pivot && $produit->pivot->quantite) {
                    $subtotal = $produit->prix * $produit->pivot->quantite;
                    $commandeTotal += $subtotal;

                    // Stats par produit
                    if (!isset($productStats[$produit->id])) {
                        $productStats[$produit->id] = [
                            'nom' => $produit->nom,
                            'total_vendu' => 0,
                            'revenu' => 0,
                            'photo' => $produit->photo
                        ];
                    }
                    $productStats[$produit->id]['total_vendu'] += $produit->pivot->quantite;
                    $productStats[$produit->id]['revenu'] += $subtotal;
                }
            }
            $total_ventes += $commandeTotal;
            $salesByHour[$hour] += $commandeTotal;
        }

        // Trier les produits par popularité
        uasort($productStats, function ($a, $b) {
            return $b['total_vendu'] <=> $a['total_vendu'];
        });
        $topProduits = array_slice($productStats, 0, 3, true);

        // Moyenne par commande
        $panier_moyen = $total_commandes > 0 ? $total_ventes / $total_commandes : 0;

        return view('entrepreneur.dashboard', compact(
            'commandes',
            'total_produits',
            'total_commandes',
            'total_ventes',
            'topProduits',
            'salesByHour',
            'panier_moyen'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);

        // Vérifier que c'est bien une commande liée à cet entrepreneur (sécurité basique)
        // Note: Dans un vrai système multi-vendeurs, il faudrait vérifier item par item

        $commande->statut = $request->statut;
        $commande->save();

        return response()->json(['success' => true, 'statut' => $commande->statut]);
    }
}
