<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Singkron extends Model
{
    protected $fillable = [
	    'waktu','keterangan','status'
	];
    public $timestamps = false;
}
