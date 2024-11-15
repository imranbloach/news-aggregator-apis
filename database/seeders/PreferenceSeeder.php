<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Preference;
use App\Models\User;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Preference::create([
                'user_id' => $user->id,
                'categories' => json_encode([1, 2]), // Use category IDs as preferred categories
                'sources' => json_encode([1, 3]), // Use source IDs as preferred sources
                //'authors' => json_encode([1, 5]), // Use author IDs as preferred authors
            ]);
        }
    }
}

