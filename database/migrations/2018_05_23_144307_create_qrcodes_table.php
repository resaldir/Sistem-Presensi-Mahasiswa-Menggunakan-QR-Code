<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQrcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('qrcodes');
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->string('qrcodeId');
            $table->primary('qrcodeId');
            $table->string('qrcodeKlsId');
            $table->dateTime('qrcodeWaktuAkhir');
            $table->integer('qrcodePertemuan');
            $table->string('qrcodeKode');
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
        Schema::dropIfExists('qrcodes');
    }
}
