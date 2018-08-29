<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('kelas');
        Schema::create('kelas', function (Blueprint $table) {
            $table->string('klsId');
            $table->primary('klsId');
            $table->string('klsMtkId');
            $table->string('klsDsnNip');
            $table->string('klsSemId');
            $table->integer('klsNama');
            $table->integer('klsJumlahPer')->unsigned();
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
        Schema::dropIfExists('kelas');
    }
}
