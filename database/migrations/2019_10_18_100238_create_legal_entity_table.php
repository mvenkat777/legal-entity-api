<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_entity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lei')->unique();
            $table->integer('version');
            $table->string('name');
            $table->string('country_code');
            $table->enum('status', ['ACTIVE', 'INACTIVE']);
            $table->boolean('validated')->default(false);
            //$table->boolean('rejected')->default(false);
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
        Schema::dropIfExists('legal_entity');
    }
}
