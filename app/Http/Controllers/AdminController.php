<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\Restriction;
use App\Notifications\RestrictionNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user() && auth()->user()->role !== 'admin') {
                return redirect()->route('login')->withErrors(['email' => 'Accès refusé.']);
            }
            return $next($request);
        });
    }

    // Affiche la liste des demandes à approuver ou rejeter
    public function index()
    {
        $demandes = User::where('role', 'entrepreneur_en_attente')->get();
        $pendingPlayersCount = User::where('role', 'client')->where('statut_joueur', 'en_attente')->count();
        return view('admin.dashboard', compact('demandes', 'pendingPlayersCount'));
    }

    // Retourne les statistiques en temps réel au format JSON
    public function statistiquesData()
    {
        $stats = [
            'entrepreneurs_approuves' => User::where('role', 'entrepreneur_approuve')->count(),
            'demandes_attente' => User::where('role', 'entrepreneur_en_attente')->count(),
            'approuves_aujourdhui' => User::where('role', 'entrepreneur_approuve')
                ->whereDate('updated_at', now()->toDateString())
                ->whereColumn('updated_at', '>', 'created_at')
                ->count(),
            'rejetes_aujourdhui' => User::where('role', 'rejeté')
                ->whereDate('updated_at', now()->toDateString())
                ->whereColumn('updated_at', '>', 'created_at')
                ->count(),
            'total_commandes' => \App\Models\Commande::count(),
            'total_produits' => \App\Models\Produit::count(),
            'commandes_semaine' => \App\Models\Commande::where('created_at', '>=', now()->startOfWeek())->count(),
            'commandes_mois' => \App\Models\Commande::where('created_at', '>=', now()->startOfMonth())->count(),
            'nouveaux_entrepreneurs' => User::where('role', 'entrepreneur_approuve')
                ->where('created_at', '>=', now()->startOfWeek())
                ->count(),
            'chiffre_affaires_mois' => $this->calculerChiffreAffairesMois(),
        ];

        // Récupérer les 5 entrepreneurs avec le plus de commandes
        $top_entrepreneurs = User::where('role', 'entrepreneur_approuve')
            ->withCount([
                'commandes' => function ($query) {
                    $query->where('created_at', '>=', now()->subMonth());
                }
            ])
            ->orderByDesc('commandes_count')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nom_entreprise' => $user->nom_entreprise,
                    'email' => $user->email,
                    'commandes_count' => $user->commandes_count,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s')
                ];
            });

        // Récupérer les activités récentes (ex: 10 dernières)
        $activites_recentes = [];
        /* \App\Models\Activite::with('user')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($activite) {
                return [
                    'id' => $activite->id,
                    'type' => $activite->type,
                    'description' => $activite->description,
                    'user_name' => $activite->user ? $activite->user->nom_entreprise : 'Système',
                    'created_at' => $activite->created_at->format('Y-m-d H:i:s'),
                    'time_ago' => $activite->created_at->diffForHumans()
                ];
            }); */

        return response()->json([
            'stats' => $stats,
            'top_entrepreneurs' => $top_entrepreneurs,
            'activites_recentes' => $activites_recentes,
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function demandes()
    {
        $demandes = User::where('role', 'entrepreneur_en_attente')
            ->orderByDesc('created_at')
            ->get(['id', 'email', 'nom_entreprise', 'created_at']);

        return response()->json([
            'count' => $demandes->count(),
            'demandes' => $demandes,
        ]);
    }

    // Affiche les commandes par entrepreneur
    public function commandesEntrepreneurs()
    {
        $entrepreneurs = User::where('role', 'entrepreneur_approuve')->with([
            'produits.commandes' => function ($q) {
                $q->with('produits');
            }
        ])->get();
        return view('admin.commandes-entrepreneurs', compact('entrepreneurs'));
    }

    // Affiche les statistiques
    public function statistiques()
    {
        // Statistiques générales
        $stats = [
            'entrepreneurs_approuves' => User::where('role', 'entrepreneur_approuve')->count(),
            'demandes_attente' => User::where('role', 'entrepreneur_en_attente')->count(),
            'total_commandes' => Commande::count(),
            'total_produits' => Produit::count(),
            'commandes_semaine' => Commande::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
            'commandes_mois' => Commande::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'nouveaux_entrepreneurs' => User::where('role', 'entrepreneur_approuve')
                ->where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
            'chiffre_affaires_mois' => $this->calculerChiffreAffairesMois(),
        ];

        // Top 5 des entrepreneurs
        $top_entrepreneurs = User::where('role', 'entrepreneur_approuve')
            ->with([
                'produits.commandes' => function ($q) {
                    $q->with('produits');
                }
            ])
            ->get()
            ->map(function ($entrepreneur) {
                $commandes = collect();
                $total_ventes = 0;

                foreach ($entrepreneur->produits as $produit) {
                    if ($produit->commandes) {
                        foreach ($produit->commandes as $commande) {
                            $commandes->push($commande);

                            // Calculer les ventes pour ce produit
                            if ($produit->prix && $produit->pivot && $produit->pivot->quantite) {
                                $total_ventes += $produit->prix * $produit->pivot->quantite;
                            }
                        }
                    }
                }

                $commandes = $commandes->unique('id');

                return (object) [
                    'id' => $entrepreneur->id,
                    'nom_entreprise' => $entrepreneur->nom_entreprise,
                    'email' => $entrepreneur->email,
                    'total_commandes' => $commandes->count(),
                    'total_ventes' => $total_ventes,
                ];
            })
            ->sortByDesc('total_commandes')
            ->take(5);

        // Activités récentes (simulation)
        $activites_recentes = collect();

        // Ajouter les entrepreneurs récemment approuvés
        $entrepreneurs_recents = User::where('role', 'entrepreneur_approuve')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->get();

        foreach ($entrepreneurs_recents as $entrepreneur) {
            $activites_recentes->push((object) [
                'created_at' => $entrepreneur->created_at,
                'nom_entreprise' => $entrepreneur->nom_entreprise,
                'type' => 'approbation',
                'details' => 'Entrepreneur approuvé'
            ]);
        }

        // Ajouter les commandes récentes
        $commandes_recentes = Commande::where('created_at', '>=', Carbon::now()->subDays(7))
            ->with('produits.user')
            ->get();

        foreach ($commandes_recentes as $commande) {
            if ($commande->produits) {
                foreach ($commande->produits as $produit) {
                    if ($produit && $produit->user) {
                        $activites_recentes->push((object) [
                            'created_at' => $commande->created_at,
                            'nom_entreprise' => $produit->user->nom_entreprise,
                            'type' => 'commande',
                            'details' => "Commande #{$commande->id} - {$produit->nom}"
                        ]);
                    }
                }
            }
        }

        // Ajouter les nouveaux produits
        $produits_recents = Produit::where('created_at', '>=', Carbon::now()->subDays(7))
            ->with('user')
            ->get();

        foreach ($produits_recents as $produit) {
            if ($produit->user) {
                $activites_recentes->push((object) [
                    'created_at' => $produit->created_at,
                    'nom_entreprise' => $produit->user->nom_entreprise,
                    'type' => 'produit',
                    'details' => "Nouveau produit: {$produit->nom}"
                ]);
            }
        }

        $activites_recentes = $activites_recentes->sortByDesc('created_at')->take(10);

        return view('admin.statistiques', compact('stats', 'top_entrepreneurs', 'activites_recentes'));
    }

    // Affiche les courbes de tendance
    public function tendances()
    {
        return view('admin.tendances');
    }

    // Affiche la page des restrictions
    public function restrictions()
    {
        $entrepreneurs = User::where('role', 'entrepreneur_approuve')->get();
        $restrictions = Restriction::with('entrepreneur')->orderBy('created_at', 'desc')->get();

        return view('admin.restrictions', compact('entrepreneurs', 'restrictions'));
    }

    // Créer une nouvelle restriction
    public function storeRestriction(Request $request)
    {
        $request->validate([
            'entrepreneur_id' => 'required|exists:users,id',
            'restriction_type' => 'required|in:temporaire,permanente,avertissement',
            'duration' => 'required|integer|min:1|max:365',
            'start_date' => 'required|date',
            'motif' => 'required|string|max:1000',
        ]);

        // Vérifier que l'utilisateur est un entrepreneur
        $entrepreneur = User::findOrFail($request->entrepreneur_id);
        if ($entrepreneur->role !== 'entrepreneur_approuve') {
            return redirect()->back()->with('error', 'Cet utilisateur n\'est pas un entrepreneur approuvé.');
        }

        // Créer la restriction
        $restriction = Restriction::create([
            'entrepreneur_id' => $request->entrepreneur_id,
            'admin_id' => auth()->id(),
            'type' => $request->restriction_type,
            'duration' => $request->duration,
            'start_date' => $request->start_date,
            'end_date' => Carbon::parse($request->start_date)->addDays($request->duration),
            'motif' => $request->motif,
            'is_active' => true,
        ]);

        // Envoyer une notification à l'entrepreneur (avec gestion d'erreur)
        try {
            $entrepreneur->notify(new RestrictionNotification($restriction));
            $message = 'Restriction appliquée avec succès et notification envoyée.';
        } catch (\Exception $e) {
            // En cas d'erreur SMTP, on continue sans notification
            $message = 'Restriction appliquée avec succès. (Erreur email: ' . $e->getMessage() . ')';
        }

        return redirect()->route('admin.restrictions')->with('status', $message);
    }

    // Réactiver un compte
    public function activateAccount($id)
    {
        $restriction = Restriction::findOrFail($id);
        $restriction->activate();

        return redirect()->route('admin.restrictions')->with('status', 'Compte réactivé avec succès.');
    }

    // Prolonger une restriction
    public function extendRestriction(Request $request, $id)
    {
        $request->validate([
            'duration' => 'required|integer|min:1|max:365',
            'motif' => 'required|string|max:500',
        ]);

        $restriction = Restriction::findOrFail($id);
        $restriction->extend($request->duration, $request->motif);

        return redirect()->route('admin.restrictions')->with('status', 'Restriction prolongée avec succès.');
    }

    // Supprimer une restriction
    public function deleteRestriction($id)
    {
        $restriction = Restriction::findOrFail($id);
        $restriction->delete();

        return redirect()->route('admin.restrictions')->with('status', 'Restriction supprimée avec succès.');
    }

    // Calculer le chiffre d'affaires du mois
    private function calculerChiffreAffairesMois()
    {
        $commandes_mois = Commande::where('created_at', '>=', Carbon::now()->startOfMonth())
            ->with('produits')
            ->get();

        $total = 0;
        foreach ($commandes_mois as $commande) {
            foreach ($commande->produits as $produit) {
                if ($produit->prix && $produit->pivot && $produit->pivot->quantite) {
                    $total += $produit->prix * $produit->pivot->quantite;
                }
            }
        }

        return $total;
    }

    // Approuver un utilisateur
    public function approuver($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === 'entrepreneur_en_attente') {
                $user->role = 'entrepreneur_approuve';
                $user->motif_rejet = null; // Supprime le motif s'il existe
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => "L'utilisateur {$user->email} a été approuvé avec succès."
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => "Impossible d'approuver cet utilisateur."
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Une erreur est survenue : " . $e->getMessage()
            ], 500);
        }
    }

    // Rejeter un utilisateur avec motif
    public function rejeter(Request $request, $id)
    {
        try {
            $request->validate([
                'motif_rejet' => 'required|string|max:500',
            ]);

            $user = User::findOrFail($id);

            if ($user->role === 'entrepreneur_en_attente') {
                $user->role = 'rejeté';
                $user->motif_rejet = $request->motif_rejet;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => "L'utilisateur {$user->email} a été rejeté avec succès."
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => "Impossible de rejeter cet utilisateur."
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Une erreur est survenue : " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gestion des Joueurs du Défi Elite Gold
     */
    public function joueursIndex()
    {
        $pendingPlayers = User::where('role', 'client')->where('statut_joueur', 'en_attente')->get();
        $approvedPlayers = User::where('role', 'client')->where('statut_joueur', 'approuve')->get();
        $rejectedPlayers = User::where('role', 'client')->where('statut_joueur', 'rejete')->get();

        // Statistiques avancées
        $stats = [
            'total_pepites' => User::where('role', 'client')->sum('pepites'),
            'count_or' => User::where('role', 'client')->where('rang', 'Or')->count(),
            'count_argent' => User::where('role', 'client')->where('rang', 'Argent')->count(),
            'count_bronze' => User::where('role', 'client')->where('rang', 'Bronze')->count(),
        ];

        return view('admin.joueurs', compact('pendingPlayers', 'approvedPlayers', 'rejectedPlayers', 'stats'));
    }

    public function validerJoueur($id)
    {
        $user = User::findOrFail($id);
        $user->statut_joueur = 'approuve';
        $user->save();

        return redirect()->back()->with('status', "Le joueur {$user->nom_entreprise} a été approuvé !");
    }

    public function rejeterJoueur($id)
    {
        $user = User::findOrFail($id);
        $user->statut_joueur = 'rejete';
        $user->save();

        return redirect()->back()->with('status', "La candidature de {$user->nom_entreprise} a été rejetée.");
    }
}
