<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikelPotensiSDA extends Model
{
    use HasFactory;
    protected $table = 'artikel_potensi_s_d_a_s';
    protected $fillable = [
        'nama_artikel',
        'isi_artikel',
        'image',
        'views'
    ];   
}
