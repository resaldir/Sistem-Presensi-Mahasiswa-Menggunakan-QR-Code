<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mtks', function (Blueprint $table) {
            $table->string('mtkId');
            $table->primary('mtkId');
            $table->string('mtkNama');
            $table->integer('mtkKurId');
            $table->integer('mtkSemester');
            $table->integer('mtkTotalSks');
            $table->integer('mtkTeoriSks');
            $table->integer('mtkPraktekSks');
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
        Schema::dropIfExists('mtks');
    }
}
