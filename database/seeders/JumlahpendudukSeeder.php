<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jumlahpenduduk;

class JumlahpendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jumlahpenduduk = Jumlahpenduduk::create([
            'jumlah_penduduk' => '10000'
        ]);
    }
}
