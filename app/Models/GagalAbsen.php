<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GagalAbsen extends Model
{
    protected $fillable = [
	    'id_finger','dimensi_waktu','waktu_input'
	];
}
