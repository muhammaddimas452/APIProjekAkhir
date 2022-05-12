<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class umkm extends Model
{
    use HasFactory;
    protected $table = 'umkms';
    protected $fillable = [
        'nama_usaha',
        'isi_usaha',
        'image',
        'views'
    ];   
}
