<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'mrchesca452@gmail.com',
            'name' => 'Dimas',
            'password' => Hash::make('secret'),
            'status' => 'aktif'
        ]);
    }
}
