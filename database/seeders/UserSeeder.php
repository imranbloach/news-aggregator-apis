<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Imran Bloach',
            'email' => 'imran@gmail.com',
            'password' => Hash::make('Test@1234'),
        ]);

        User::factory(10)->create();
    }
}

