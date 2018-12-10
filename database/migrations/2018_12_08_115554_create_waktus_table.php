<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaktusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waktus', function (Blueprint $table) {
            $table->increments('id');
            $table->time('masuk_1');
            $table->time('keluar_1');
            $table->time('masuk_2');
            $table->time('keluar_2');
            $table->time('batas_pencatatan');
            $table->time('singkron_auto');
            $table->time('clear_auto');
            $table->enum('status',['Aktif', 'Non Aktif'])->default('Non Aktif');
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
        Schema::dropIfExists('waktus');
    }
}
