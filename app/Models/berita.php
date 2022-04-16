<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class berita extends Model
{
    use HasFactory;
    protected $table = 'beritas';
    protected $fillable = [
        'nama_artikel',
        'isi_artikel',
        'image',
        'views'
    ]; 
}
