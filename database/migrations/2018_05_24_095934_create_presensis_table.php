<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->increments('presensiId');
            $table->string('presensiKlsId');
            $table->integer('presensiKrsId');
            $table->string('presensiQrcodeKode');
            $table->integer('presensiStatus');
            $table->decimal('long', 10, 7);
            $table->decimal('lat', 10, 7);
            $table->string('presensiDevId');
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
        Schema::dropIfExists('presensis');
    }
}
