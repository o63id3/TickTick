<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');

         User::factory()->create([
             'name' => 'Demo user',
             'email' => 'demo@mail.com',
         ]);
//         User::factory(10)->create();

         $this->call([
             AppListSeeder::class,
             SectionSeeder::class,
             TaskSeeder::class,
             TaskItemSeeder::class,
         ]);
    }
}
