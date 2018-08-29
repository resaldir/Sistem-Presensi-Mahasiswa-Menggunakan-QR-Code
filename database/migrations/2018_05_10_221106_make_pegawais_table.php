<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::dropIfExists('pegawais');
        Schema::create('pegawais', function (Blueprint $table) {
            $table->integer('pegId');
            $table->primary('pegId');
            $table->string('pegNama');
            $table->integer('pegProdiKode');
            $table->string('pegFoto')->default(null);
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
        Schema::dropIfExists('pegawais');
    }
}