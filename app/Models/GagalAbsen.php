<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GagalAbsen extends Model
{
    protected $fillable = [
	    'id_rekam','id_finger','dimensi_waktu','tanggal','waktu_input'
	];
}
