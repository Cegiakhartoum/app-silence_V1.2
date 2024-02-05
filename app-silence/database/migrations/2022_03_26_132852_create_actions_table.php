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
            $table->integer('owner_id');
            $table->integer('owner_type');
            $table->integer('projet_action_id');
            $table->string('titre_oeuvre')->nullable();
            $table->string('thematique')->nullable();
            $table->string('pitch')->nullable();
            $table->string('situtation_initiale')->nullable();
            $table->string('element_pertubateur')->nullable();
            $table->string('peripeties')->nullable();
            $table->string('element_resolution')->nullable();
            $table->string('situation_finale')->nullable();
            $table->string('synopsis')->nullable();
            $table->string('titre_film')->nullable();
            $table->timestamps();
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
