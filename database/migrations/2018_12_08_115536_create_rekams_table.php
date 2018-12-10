<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mesin');
            $table->integer('id_absen')->nullable();
            $table->integer('id_finger');
            $table->integer('id_even')->nullable();
            $table->date('tanggal');
            $table->time('masuk_1')->nullable();
            $table->time('keluar_1')->nullable();
            $table->time('masuk_2')->nullable();
            $table->time('keluar_2')->nullable();
            $table->integer('id_user_edit')->nullable();
            $table->string('keterangan')->default('Hari Normal');
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
        Schema::dropIfExists('rekams');
    }
}
