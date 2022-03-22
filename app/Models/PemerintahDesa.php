<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PemerintahDesa extends Model
{
    use HasFactory;
    protected $table = 'pemerintahdesa';
    protected $fillable = ['name', 'jabatan_id', 'gambar_pemerintah'];

    public function jabatan()
    {
        return $this->belongsTo(jabatan::class, 'jabatan_id');
    }
}
