<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSingkronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('singkrons', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('waktu')->useCurrent();
            $table->text('keterangan')->nullable();
            $table->enum('status',['Berhasil','Gagal']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('singkrons');
    }
}
