<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuangansTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ruangans');
        Schema::create('ruangans', function (Blueprint $table) {
            $table->increments('ruanganId');
            $table->string('ruanganKode');
            $table->integer('ruanganProdiKode');
            $table->integer('ruanganKapasitas');
            $table->unique('ruanganKode');
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
        Schema::dropIfExists('ruangans');
    }
}
