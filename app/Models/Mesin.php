<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    protected $fillable = [
	    'ip','nomor','status'
	];
}
