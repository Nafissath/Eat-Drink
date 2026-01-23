<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class CommandeController extends Controller
{
    /**
     * Créer une nouvelle instance du contrôleur.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'annuler']);
    }
    public function create()
    {
        // Log pour déboguer
        \Log::info('Accès à la page de commande', [
            'session_id' => session()->getId(),
            'panier' => session()->get('panier', []),
            'user' => auth()->check() ? auth()->user()->id : 'guest'
        ]);

        $panier = session()->get('panier', []);

        if (empty($panier)) {
            \Log::warning('Tentative d\'accès à la commande avec un panier vide', [
                'session_id' => session()->getId(),
                'user' => auth()->check() ? auth()->user()->id : 'guest'
            ]);
            return redirect()->route('panier')->with('error', 'Votre panier est vide.');
        }

        // Calculer le total du panier
        $total = 0;
        foreach ($panier as $item) {
            $total += $item['prix'] * $item['quantite'];
        }

        return view('commandes.create', compact('panier', 'total'));
    }

    public function store(Request $request)
    {
        $panier = session()->get('panier', []);

        if (empty($panier)) {
            return redirect()->route('panier')->with('error', 'Votre panier est vide.');
        }

        $rules = Commande::$rules;
        if (!auth()->check()) {
            $rules['email_client'] = 'required|email|max:255';
        }

        // Valider les données du formulaire
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            \Log::warning('Validation Commande échouée', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->except(['_token', 'password']),
                'user_id' => auth()->id() ?? 'guest',
                'session_id' => session()->getId()
            ]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Vérifier la disponibilité des produits
        foreach ($panier as $id => $item) {
            $produit = Produit::find($id);
            // Stock check removed as per user request (products always available)
            if (!$produit) {
                return redirect()->back()
                    ->with('error', "Le produit {$item['nom']} n'existe plus.")
                    ->withInput();
            }
        }

        // Calculer le total de la commande
        $total = 0;
        foreach ($panier as $id => $item) {
            $total += $item['prix'] * $item['quantite'];
        }

        $typeCommande = $request->input('type_commande');

        // Créer la commande avec les données selon le type
        $commandeData = [
            'user_id' => auth()->id() ?? null,
            'type_commande' => $typeCommande,
            'numero_table' => $typeCommande === 'sur_place' ? $request->numero_table : null,
            'nom_client' => $request->nom_client,
            'telephone' => $request->telephone,
            'email_client' => auth()->check() ? null : $request->email_client,
            'adresse' => $typeCommande === 'livraison' ? $request->adresse : null,
            'ville' => $typeCommande === 'livraison' ? $request->ville : null,
            'code_postal' => $typeCommande === 'livraison' ? $request->code_postal : null,
            'instructions' => $request->instructions,
            'statut' => 'en_attente',
            'total' => $total
        ];

        // Démarrer une transaction de base de données
        \DB::beginTransaction();

        try {
            // Créer la commande
            $commande = Commande::create($commandeData);

            // Associer les produits à la commande et mettre à jour les quantités
            foreach ($panier as $id => $item) {
                $produit = Produit::find($id);

                // Associer le produit à la commande
                $commande->produits()->attach($id, [
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix']
                ]);
            }

            // Valider la transaction
            \DB::commit();

            // Attribution des pépites (Système Elite Gold)
            if (auth()->check() && auth()->user()->isJoueurApprouve()) {
                $pepitesGagnees = floor($total / 1000);
                if ($pepitesGagnees > 0) {
                    auth()->user()->ajouterPepites($pepitesGagnees);
                }
            }

            // Vider le panier
            session()->forget('panier');
            \Log::info('Panier vidé après création de la commande');

            // Afficher directement la vue de confirmation
            \Log::info('Affichage de la page de confirmation pour la commande: ' . $commande->id);

            // Afficher la vue appropriée selon le type de commande
            if ($commande->type_commande === 'sur_place') {
                return view('commandes.beeper', compact('commande'));
            }

            return view('commandes.confirmation', compact('commande'))
                ->with('success', 'Votre commande a été enregistrée avec succès !');

        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            \DB::rollBack();
            \Log::error('Erreur lors de la création de la commande: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de votre commande. Veuillez réessayer.')
                ->withInput();
        }
    }

    public function confirmation($id)
    {
        \Log::info('Accès à la page de confirmation', [
            'commande_id' => $id,
            'signed' => request()->hasValidSignature(),
            'user' => auth()->check() ? auth()->id() : 'guest'
        ]);

        $commande = Commande::with('produits')->findOrFail($id);

        // Vérifier que l'URL est signée
        if (!request()->hasValidSignature()) {
            \Log::warning('Tentative d\'accès non autorisée à la page de confirmation', [
                'commande_id' => $id,
                'ip' => request()->ip()
            ]);

            return redirect()->route('accueil')
                ->with('error', 'Lien de confirmation invalide ou expiré.');
        }

        if ($commande->type_commande === 'sur_place') {
            return view('commandes.beeper', compact('commande'));
        }

        return view('commandes.confirmation', compact('commande'));
    }

    public function rechercher()
    {
        return view('commandes.rechercher');
    }

    public function rechercherProcess(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'telephone' => 'required|string',
        ]);

        $commande = Commande::where('id', $request->id)
            ->where('telephone', $request->telephone)
            ->first();

        if (!$commande) {
            return redirect()->back()
                ->with('error', 'Aucune commande prestigieuse ne correspond à ces identifiants.')
                ->withInput();
        }

        return redirect()->to(URL::signedRoute('commandes.suivi', ['id' => $commande->id]));
    }

    public function suivi($id)
    {
        $commande = Commande::with('produits')->findOrFail($id);
        return view('commandes.suivi', compact('commande'));
    }

    public function suiviStatus($id)
    {
        $commande = Commande::with('produits')->findOrFail($id);

        return response()->json([
            'id' => $commande->id,
            'statut' => $commande->statut,
            'type_commande' => $commande->type_commande,
            'numero_table' => $commande->numero_table,
            'adresse' => $commande->adresse,
            'ville' => $commande->ville,
            'code_postal' => $commande->code_postal,
            'total' => (string) $commande->total,
            'updated_at' => optional($commande->updated_at)->toIso8601String(),
        ]);
    }

    public function modifier($id)
    {
        $commande = Commande::with('produits')->findOrFail($id);

        if ($commande->statut !== 'en_attente') {
            return redirect()->to(\URL::signedRoute('commandes.suivi', ['id' => $commande->id]))
                ->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        return view('commandes.modifier', compact('commande'));
    }

    public function mettreAJour(Request $request, $id)
    {
        $commande = Commande::with('produits')->findOrFail($id);

        if ($commande->statut !== 'en_attente') {
            return redirect()->back()->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        $rules = [
            'instructions' => 'nullable|string|max:500',
        ];

        if ($commande->type_commande === 'sur_place') {
            $rules['numero_table'] = 'required|integer|min:1';
        }

        if ($commande->type_commande === 'livraison') {
            $rules['adresse'] = 'required|string|max:255';
            $rules['ville'] = 'required|string|max:100';
            $rules['code_postal'] = 'required|string|max:10';
        }

        $validated = $request->validate($rules);

        $data = [
            'instructions' => $validated['instructions'] ?? null,
        ];

        if ($commande->type_commande === 'sur_place') {
            $data['numero_table'] = $validated['numero_table'];
        }

        if ($commande->type_commande === 'livraison') {
            $data['adresse'] = $validated['adresse'];
            $data['ville'] = $validated['ville'];
            $data['code_postal'] = $validated['code_postal'];
        }

        $commande->update($data);

        return redirect()->to(\URL::signedRoute('commandes.suivi', ['id' => $commande->id]))
            ->with('success', 'Commande mise à jour avec succès.');
    }

    public function annulerClient(Request $request, $id)
    {
        $commande = Commande::with('produits')->findOrFail($id);

        if ($commande->statut !== 'en_attente') {
            return redirect()->back()->with('error', 'Cette commande ne peut plus être annulée.');
        }

        $data = $request->validate([
            'motif_annulation' => 'nullable|string|max:255',
        ]);

        \DB::beginTransaction();

        try {
            $commande->update([
                'statut' => 'annulee',
                'motif_annulation' => $data['motif_annulation'] ?? null,
            ]);

            \DB::commit();

            return redirect()->to(\URL::signedRoute('commandes.suivi', ['id' => $commande->id]))
                ->with('success', 'Commande annulée avec succès.');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Erreur lors de l\'annulation client: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'annulation.');
        }
    }

    public function index()
    {
        $commandes = auth()->check()
            ? Commande::where('user_id', auth()->id())
                ->with('produits')
                ->latest()
                ->get()
            : collect([]);

        return view('commandes_simple', compact('commandes'));
    }

    public function annuler($id)
    {
        $commande = Commande::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('statut', 'en_attente')
            ->firstOrFail();

        // Mettre à jour le statut de la commande
        $commande->update(['statut' => 'annulee']);

        return redirect()->route('commandes.index')
            ->with('success', 'La commande a été annulée avec succès.');
    }
}