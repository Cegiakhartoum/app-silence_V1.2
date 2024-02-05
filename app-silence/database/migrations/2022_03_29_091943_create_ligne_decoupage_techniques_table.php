<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneDecoupageTechniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_decoupage_techniques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id');
            $table->string('sequence', 10);
            $table->string('plan', 10);
            $table->string('duree', 20);
            $table->string('lieu', 100);
            $table->string('description', 200);
            $table->string('echelle_angle', 20);
            $table->string('mouvement_camera', 20);
            $table->string('audio', 20);
            $table->string('raccord', 20);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            
            $table->foreign('action_id', 'ligne_decoupage_techniques_ibfk_1')->references('id')->on('actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligne_decoupage_techniques');
    }
}
