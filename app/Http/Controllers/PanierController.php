<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Exposant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function panierExposants()
    {
        $panierExposants = session()->get('panier_exposants', []);
        return view('panier.index_exposants', compact('panierExposants'));
    }

    public function ajouterExposant($id)
    {
        $exposant = Exposant::findOrFail($id);
        $panierExposants = session()->get('panier_exposants', []);

        if (!isset($panierExposants[$id])) {
            $panierExposants[$id] = [
                "nom" => $exposant->nom,
                "stand" => $exposant->stand ?? '',
            ];
            session()->put('panier_exposants', $panierExposants);
        }

        return redirect()->back()->with('success', 'Exposant ajouté au panier !');
    }

    public function retirerExposant($id)
    {
        $panierExposants = session()->get('panier_exposants', []);
        if (isset($panierExposants[$id])) {
            unset($panierExposants[$id]);
            session()->put('panier_exposants', $panierExposants);
        }
        return redirect()->route('panier.exposants')->with('success', 'Exposant retiré du panier !');
    }

    public function ajouter($id)
    {
        $produit = Produit::findOrFail($id);

        if (!$produit->est_disponible) {
            return redirect()->back()->with('error', 'Désolé, ce produit est actuellement indisponible.');
        }

        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantite']++;
        } else {
            $panier[$id] = [
                'id' => $produit->id,
                'nom' => $produit->nom,
                'prix' => $produit->prix,
                'photo' => $produit->photo,
                'quantite' => 1,
                'exposant_id' => $produit->user_id
            ];
        }

        session(['panier' => $panier]);

        return redirect()->route('panier')
            ->with('success', 'Produit ajouté au panier')
            ->with('scroll_to_panier', true);
    }

    public function retirer(Request $request, $id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            if ($request->has('remove_all') || $panier[$id]['quantite'] <= 1) {
                unset($panier[$id]);
            } else {
                $panier[$id]['quantite']--;
            }
            session(['panier' => $panier]);
        }

        return redirect()->route('panier')->with('success', 'Produit retiré du panier');
    }

    public function index()
    {
        $panier = session()->get('panier', []);
        $total = 0;

        // Charger les produits de la DB pour vérifier la disponibilité actuelle
        $produitIds = array_keys($panier);
        $produitsDb = Produit::whereIn('id', $produitIds)->get()->keyBy('id');

        // Calculer le total et attacher l'info de disponibilité
        foreach ($panier as $id => &$item) {
            $total += $item['prix'] * $item['quantite'];
            $item['est_disponible'] = isset($produitsDb[$id]) ? $produitsDb[$id]->est_disponible : false;
        }

        return view('panier.index', [
            'panier' => $panier,
            'total' => $total,
            'estConnecte' => Auth::check()
        ]);
    }
}