<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waktu extends Model
{
    protected $fillable = [
	    'masuk_1','keluar_1','masuk_2','keluar_2','batas_pencatatan','singkron_auto','clear_auto','status'
	];
}
