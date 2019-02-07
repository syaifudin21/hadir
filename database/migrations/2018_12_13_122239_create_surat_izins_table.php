<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratIzinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_izins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nisn');
            $table->integer('id_finger');
            $table->enum('izin',['Izin', 'Sakit']);
            $table->date('mulai')->useCurrent();
            $table->date('selesai')->nullable();
            $table->text('alasan');
            $table->text('bukti');
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
        Schema::dropIfExists('surat_izins');
    }
}
