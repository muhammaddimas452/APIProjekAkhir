<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoWilayah extends Model
{
    use HasFactory;
    protected $table = 'infowilayah';
    protected $fillabel = [
        'nama_desa',
        'rt',
        'rw',
        'kepala_desa'
    ];
}
