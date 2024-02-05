<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSequenceScenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequence_scenarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id');
            $table->string('ext_int', 50);
            $table->string('lieu', 500);
            $table->string('jour_nuit', 20);
            $table->string('personnages', 500);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            
            $table->foreign('action_id', 'sequence_scenarios_ibfk_1')->references('id')->on('actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sequence_scenarios');
    }
}
