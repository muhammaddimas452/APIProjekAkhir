<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class textberanda extends Model
{
    use HasFactory;
    protected $table = 'textberandas';
    protected $fillable = [
        'text_1',
        'text_2',
    ];
}
