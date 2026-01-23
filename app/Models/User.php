<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nom_entreprise',
        'email',
        'password',
        'role',
        'pepites',
        'rang',
        'statut_joueur',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    /**
     * Génère une URL de logo pro et unique pour l'entreprise
     */
    public function getLogoUrlAttribute()
    {
        $name = $this->nom_entreprise ?? 'Exposant';
        $colors = ['198754', '2 E7D32', '0d6efd', '6f42c1', 'fd7e14', 'dc3545', '20c997', '0cefac', 'e83e8c', '6610f2'];

        $hash = crc32($name);
        $color = $colors[abs($hash) % count($colors)];

        return "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background={$color}&color=fff&size=256&font-size=0.4&bold=true&length=2&rounded=true";
    }

    /**
     * Ajoute des pépites et met à jour le rang si nécessaire
     */
    public function ajouterPepites($montant)
    {
        $this->pepites += $montant;
        $this->updateRang();
        $this->save();
    }

    /**
     * Met à jour le rang basé sur le nombre de pépites
     */
    protected function updateRang()
    {
        if ($this->pepites >= 150) {
            $this->rang = 'Or';
        } elseif ($this->pepites >= 50) {
            $this->rang = 'Argent';
        } else {
            $this->rang = 'Bronze';
        }
    }

    /**
     * Vérifie si l'utilisateur est un joueur approuvé
     */
    public function isJoueurApprouve()
    {
        return $this->statut_joueur === 'approuve';
    }

    /**
     * Vérifie si l'utilisateur est en attente d'approbation
     */
    /**
     * Vérifie si l'utilisateur est en attente d'approbation
     */
    public function isJoueurEnAttente()
    {
        return $this->statut_joueur === 'en_attente';
    }

    /**
     * Récupère la dernière commande active
     */
    public function getActiveOrder()
    {
        return \App\Models\Commande::where('user_id', $this->id)
            ->whereNotIn('statut', ['terminee', 'annulee'])
            ->latest()
            ->first();
    }
}

