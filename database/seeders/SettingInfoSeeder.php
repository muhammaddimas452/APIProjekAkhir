<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\settingInfo;

class SettingInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        settingInfo::create([
            'lokasi_desa' => 'contoh',
            'email_desa' => 'contoh',
            'nomor_hp1' => '223',
            'nomor_hp2' => '334',
            'link_fb' => 'http',
            'link_twitter' => 'http',
            'link_ig' => 'http',
            'link_yt' => 'http'
        ]);
    }
}
