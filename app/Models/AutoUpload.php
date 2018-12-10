<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoUpload extends Model
{
    protected $fillable = [
	    'time','status'
	];
    public $timestamps = false;
}
