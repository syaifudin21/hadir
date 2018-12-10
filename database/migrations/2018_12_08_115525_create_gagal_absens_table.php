<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGagalAbsensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gagal_absens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_finger');
            $table->enum('dimensi_waktu',['masuk_1','keluar_1','masuk_2','keluar_2']);
            $table->timestamp('waktu_input');
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
        Schema::dropIfExists('gagal_absens');
    }
}
