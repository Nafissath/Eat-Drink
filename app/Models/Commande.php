<?php

namespace App\Models;

use App\Notifications\CommandeStatutNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class Commande extends Model
{
    protected static function booted()
    {
        static::updated(function (Commande $commande) {
            if (!$commande->wasChanged('statut')) {
                return;
            }

            if ($commande->getOriginal('statut') === null) {
                return;
            }

            $email = $commande->user?->email ?? $commande->email_client;
            if (!$email) {
                return;
            }

            $send = function () use ($email, $commande) {
                Notification::route('mail', $email)->notify(new CommandeStatutNotification($commande));
            };

            if (DB::transactionLevel() > 0) {
                DB::afterCommit($send);
                return;
            }

            $send();
        });
    }

    protected $fillable = [
        'user_id',
        'type_commande',
        'numero_table',
        'nom_client',
        'telephone',
        'email_client',
        'adresse',
        'ville',
        'code_postal',
        'instructions',
        'total',
        'statut',
        'motif_annulation'
    ];

    protected $casts = [
        'type_commande' => 'string',
        'statut' => 'string',
        'total' => 'decimal:2'
    ];

    public static $rules = [
        'type_commande' => 'required|in:sur_place,livraison',
        'numero_table' => 'required_if:type_commande,sur_place|nullable|integer|min:1',
        'nom_client' => 'required|string|max:100',
        'telephone' => 'required|string|max:20',
        'email_client' => 'nullable|email|max:255',
        'adresse' => 'required_if:type_commande,livraison|nullable|string|max:255',
        'ville' => 'required_if:type_commande,livraison|nullable|string|max:100',
        'code_postal' => 'required_if:type_commande,livraison|nullable|string|max:10',
        'instructions' => 'nullable|string|max:500',
    ];

   public function user() {
    return $this->belongsTo(User::class);
}

public function produits()
{
    return $this->belongsToMany(Produit::class)->withPivot('quantite');
}


}
