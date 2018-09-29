<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mahasiswas');
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('mhsId');
            $table->primary('mhsId');
            $table->string('mhsNama');
            $table->integer('mhsProdiKode');
            $table->integer('mhsAngkatan');
            $table->integer('mhsKurId');
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
        Schema::dropIfExists('mahasiswas');
    }
}
