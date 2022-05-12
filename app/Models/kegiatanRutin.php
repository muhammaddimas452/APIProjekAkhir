<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kegiatanRutin extends Model
{
    use HasFactory;
    protected $table = 'kegiatan_rutins';
    protected $fillable = [
        'tanggal_kegiatan',
        'nama_kegiatan',
        'image',
        'status'
    ];
}
