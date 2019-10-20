<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalEntityHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_entity_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('legal_entity_id');
            $table->integer('version');
            $table->string('name');
            $table->string('country_code');
            $table->enum('status', ['ACTIVE', 'INACTIVE']);
            $table->dateTime('date_changed');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_entity_history');
    }
}
