<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHariLibursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hari_liburs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_finger')->nullable();
            $table->date('waktu_mulai_libur');
            $table->date('waktu_selesai_libur');
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
        Schema::dropIfExists('hari_liburs');
    }
}
