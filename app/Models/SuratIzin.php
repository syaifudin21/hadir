<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratIzin extends Model
{
    protected $fillable = [
	    'nisn','id_finger','izin','mulai','selesai','alasan','bukti'
	];
}
