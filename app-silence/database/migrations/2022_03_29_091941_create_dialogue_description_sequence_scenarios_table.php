<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDialogueDescriptionSequenceScenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialogue_description_sequence_scenarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('description_sequence_id');
            $table->string('personnage', 50);
            $table->string('didascalie', 100);
            $table->string('dialogue', 500);
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
        Schema::dropIfExists('dialogue_description_sequence_scenarios');
    }
}
