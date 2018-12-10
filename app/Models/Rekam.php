<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekam extends Model
{
    protected $fillable = [
	    'id_mesin','id_absen','id_finger','id_even','tanggal','masuk_1','keluar_1','masuk_2','keluar_2','id_user_edit','keterangan'
	];
}
