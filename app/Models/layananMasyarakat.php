<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class layananMasyarakat extends Model
{
    use HasFactory;
    protected $table = 'layanan_masyarakats';
    protected $fillable = [
        'nama_layanan',
        'isi_layanan',
        'image',
        'views'
    ];  
}
