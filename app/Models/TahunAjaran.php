<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
	    'tahun_ajaran','mulai','selesai', 'status'
	];
}
