<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');
            $table->integer('projet_action_id');
            $table->string('titre_oeuvre', 200);
            $table->string('thematique', 500);
            $table->string('pitch', 500);
            $table->string('situtation_initiale', 500);
            $table->string('element_pertubateur', 500);
            $table->string('peripeties', 500);
            $table->integer('element_resolution');
            $table->string('situation_finale', 500);
            $table->string('synopsis', 500);
            $table->string('titre_film', 200);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
