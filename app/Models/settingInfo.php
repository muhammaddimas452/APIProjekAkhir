<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settingInfo extends Model
{
    use HasFactory;
    protected $table = 'setting_infos';
    protected $fillable = [
        'lokasi_desa',
        'email_desa',
        'nomor_hp1',
        'nomor_hp2',
        'link_fb',
        'link_twitter',
        'link_ig',
        'link_yt',
    ];
}
