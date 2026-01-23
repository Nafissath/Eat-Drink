<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('type_commande')->default('livraison')->after('user_id');
            $table->string('nom_client')->after('type_commande');
            $table->string('telephone')->after('nom_client');
            $table->text('adresse')->nullable()->after('telephone');
            $table->string('ville')->nullable()->after('adresse');
            $table->string('code_postal')->nullable()->after('ville');
            $table->text('instructions')->nullable()->after('code_postal');
            $table->decimal('total', 10, 2)->after('instructions');
            $table->string('statut')->default('en_attente')->after('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn([
                'type_commande',
                'nom_client',
                'telephone',
                'adresse',
                'ville',
                'code_postal',
                'instructions',
                'total',
                'statut'
            ]);
        });
    }
};
