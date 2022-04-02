<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikel extends Model
{
    use HasFactory;
    protected $table = 'artikel';
    protected $fillable = [
        'nama_artikel',
        'isi_artikel',
        'image',
        'tanggal',
        
    ];
}
