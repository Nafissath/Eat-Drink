<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\ExposantController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RestrictionController;

// Page d'accueil
Route::view('/', 'accueil')->name('accueil');
Route::view('/accueil', 'accueil')->name('accueil');

// Club Privé (Fidélité)
Route::get('/club-prive', function () {
    $user = auth()->user();
    if ($user->statut_joueur === 'en_attente') {
        return view('client.attente-approbation');
    }
    if ($user->statut_joueur === 'none') {
        return redirect()->route('accueil')->with('info', 'Vous devez rejoindre le Défi Elite Gold pour accéder au Club Privé.');
    }
    return view('client.club-prive');
})->name('client.club-prive')->middleware('auth');

// Authentification (login/inscription)
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::view('/inscription', 'auth.inscription')->name('auth.inscription');
Route::post('/inscription', [AuthController::class, 'inscriptionPost'])->name('auth.inscriptionPost');

// Inscription au Défi Elite Gold
Route::view('/inscription-defi', 'auth.inscription-defi')->name('auth.inscription-defi');
Route::post('/inscription-defi', [AuthController::class, 'inscriptionDefiPost'])->name('auth.inscription-defi.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Statut de l'inscription (ex: entrepreneur en attente)
Route::view('/statut', 'auth.statut')->name('auth.statut');

// Page de restriction de compte
Route::get('/restriction', [RestrictionController::class, 'show'])->name('auth.restriction');
Route::post('/restriction/check', [RestrictionController::class, 'checkRestriction'])->name('auth.restriction.check');
Route::post('/restriction/contact', [RestrictionController::class, 'contactAdmin'])->name('auth.restriction.contact');

// Page de test pour les restrictions (admin seulement)
Route::get('/dashboard/test-restriction', function () {
    return view('admin.test-restriction-simple');
})->name('admin.test-restriction');

// Routes publiques (sans authentification)
Route::get('/exposants', [ExposantController::class, 'index'])->name('exposants.index');
Route::get('/exposants/{id}', [ExposantController::class, 'show'])->name('exposants.show');
Route::get('/exposants/{id}/produits', [ExposantController::class, 'produits'])->name('exposants.produits');

// Routes panier publiques
Route::get('/panier', [PanierController::class, 'index'])->name('panier');
Route::post('/panier/ajouter/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::post('/panier/retirer/{id}', [PanierController::class, 'retirer'])->name('panier.retirer');

// Routes de commande (accessibles sans authentification)
Route::prefix('commandes')->group(function () {
    // Route protégée pour l'historique des commandes
    Route::get('/', [CommandeController::class, 'index'])->name('commandes.index')->middleware('auth');

    // Routes accessibles sans authentification
    Route::get('/creer', [CommandeController::class, 'create'])->name('commandes.create');
    Route::post('/', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/confirmation/{id}', [CommandeController::class, 'confirmation'])
        ->name('commandes.confirmation')
        ->middleware('signed');

    // Suivie de commande (Recherche)
    Route::get('/rechercher', [CommandeController::class, 'rechercher'])->name('commandes.rechercher');
    Route::post('/rechercher', [CommandeController::class, 'rechercherProcess'])->name('commandes.rechercher.process');

    // Suivi de commande (URL signée, accessible aux invités)
    Route::get('/{id}/suivi', [CommandeController::class, 'suivi'])->name('commandes.suivi')->middleware('signed');
    Route::get('/{id}/suivi/status', [CommandeController::class, 'suiviStatus'])->name('commandes.suivi.status')->middleware('signed');

    // Modification / annulation (URL signée, accessible aux invités)
    Route::get('/{id}/modifier', [CommandeController::class, 'modifier'])->name('commandes.modifier')->middleware('signed');
    Route::put('/{id}', [CommandeController::class, 'mettreAJour'])->name('commandes.mettreAJour')->middleware('signed');
    Route::post('/{id}/annuler-client', [CommandeController::class, 'annulerClient'])->name('commandes.annulerClient')->middleware('signed');

    // Téléchargement du reçu PDF (URL signée, accessible aux invités)
    Route::get('/{id}/telecharger-recus', [PDFController::class, 'generateReceipt'])
        ->name('commandes.telechargerRecu')
        ->middleware('signed');

    // Route protégée pour l'annulation
    Route::put('/{id}/annuler', [CommandeController::class, 'annuler'])->name('commandes.annuler')->middleware('auth');
});

// Ancienne route de commande (à supprimer si elle n'est plus utilisée)
Route::post('/commande', function () {
    return redirect()->route('commandes.confirmation', 1)->with('status', 'Commande enregistrée avec succès ✨');
})->name('commande.store');

Route::view('/confirmation', 'confirmation')->name('commande.confirmation');

// Routes protégées par authentification avec vérification des restrictions
Route::middleware(['auth', 'check.restrictions'])->group(function () {
    // Routes admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/demandes', [AdminController::class, 'demandes'])->name('admin.demandes');
    Route::get('/dashboard/statistiques-data', [AdminController::class, 'statistiquesData'])->name('admin.statistiques.data');
    Route::get('/dashboard/commandes-entrepreneurs', [AdminController::class, 'commandesEntrepreneurs'])->name('admin.commandes-entrepreneurs');
    Route::get('/dashboard/statistiques', [AdminController::class, 'statistiques'])->name('admin.statistiques');
    Route::get('/dashboard/tendances', [AdminController::class, 'tendances'])->name('admin.tendances');
    Route::get('/dashboard/restrictions', [AdminController::class, 'restrictions'])->name('admin.restrictions');
    Route::post('/dashboard/restrictions', [AdminController::class, 'storeRestriction'])->name('admin.restrictions.store');
    Route::post('/dashboard/restrictions/{id}/activate', [AdminController::class, 'activateAccount'])->name('admin.restrictions.activate');
    Route::post('/dashboard/restrictions/{id}/extend', [AdminController::class, 'extendRestriction'])->name('admin.restrictions.extend');
    Route::delete('/dashboard/restrictions/{id}', [AdminController::class, 'deleteRestriction'])->name('admin.restrictions.delete');
    Route::post('/dashboard/approuver/{id}', [AdminController::class, 'approuver'])->name('admin.approuver');
    Route::post('/dashboard/rejeter/{id}', [AdminController::class, 'rejeter'])->name('admin.rejeter');

    // Gestion des Joueurs (Défi Elite Gold)
    Route::get('/dashboard/joueurs', [AdminController::class, 'joueursIndex'])->name('admin.joueurs.index');
    Route::post('/dashboard/joueurs/{id}/valider', [AdminController::class, 'validerJoueur'])->name('admin.joueurs.valider');
    Route::post('/dashboard/joueurs/{id}/rejeter', [AdminController::class, 'rejeterJoueur'])->name('admin.joueurs.rejeter');

    // Routes entrepreneur
    Route::get('/entrepreneur/dashboard', [EntrepreneurController::class, 'dashboard'])->name('entrepreneur.dashboard');

    // Routes entrepreneur avec rôle spécifique
    Route::middleware(['role:entrepreneur_approuve'])->prefix('entrepreneur')->name('entrepreneur.')->group(function () {
        Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
        Route::get('/produits/create', [ProduitController::class, 'create'])->name('produits.create');
        Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
        Route::get('/produits/{produit}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
        Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
        Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');
        Route::post('/produits/{produit}/toggle', [ProduitController::class, 'toggleStatus'])->name('produits.toggle');
        Route::resource('produits', ProduitController::class);
        Route::post('/commandes/{id}/status', [EntrepreneurController::class, 'updateStatus'])->name('commandes.updateStatus');
    });

    // Routes panier exposants
    Route::prefix('panier-exposants')->group(function () {
        Route::get('/', [PanierController::class, 'panierExposants'])->name('panier.exposants');
        Route::post('/ajouter/{id}', [PanierController::class, 'ajouterExposant'])->name('panier.ajouterExposant');
        Route::post('/retirer/{id}', [PanierController::class, 'retirerExposant'])->name('panier.retirerExposant');
    });
});