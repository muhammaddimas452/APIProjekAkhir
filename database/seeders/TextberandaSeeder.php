<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\textberanda;

class TextberandaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        textberanda::create([
            'text_1' => 'Selamat Datang Di Website Desa Jonggol',
            'text_2' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque gravida egestas ornare. Praesent enim nibh, hendrerit euismod dictum ut, suscipit vel purus. Proin bibendum libero in dui luctus blandit. Mauris eget augue eget ante scelerisque aliquam aliquam molestie lorem. Suspendisse quam elit, fermentum vel consequat vel, imperdiet sed lorem. Suspendisse eu odio in nibh efficitur blandit vitae id libero. Morbi at ipsum id libero porta lacinia eu quis odio. Integer eu nibh commodo, imperdiet dui vel, elementum massa. Aliquam eu tristique nibh.',
        ]);
    }
}
