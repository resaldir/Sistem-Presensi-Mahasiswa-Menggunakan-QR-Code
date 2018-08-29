<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::dropIfExists('jadwals');
        Schema::create('jadwals', function (Blueprint $table) {
            $table->increments('jdwlId');
            $table->integer('jdwlSemId');
            $table->string('jdwlKlsId');
            $table->string('jdwlHari');
            $table->string('jdwlSesiMulai');
            $table->string('jdwlSesiSelesai');
            $table->integer('jdwlRuanganId');
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
        Schema::dropIfExists('jadwals');
    }
}
