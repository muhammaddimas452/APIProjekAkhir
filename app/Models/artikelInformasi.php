<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikelInformasi extends Model
{
    use HasFactory;
    protected $table = 'artikel_informasis';
    protected $fillable = [
        'nama_artikel',
        'isi_artikel',
        'image',
        'views'
    ];    
}
