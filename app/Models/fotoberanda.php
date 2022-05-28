<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fotoberanda extends Model
{
    use HasFactory;
    protected $table = 'fotoberandas';
    protected $fillable = [
        'image',
    ]; 
}
