<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $fillable = [
	    'id_finger','waktu_mulai_libur','waktu_selesai_libur'
	];
}
