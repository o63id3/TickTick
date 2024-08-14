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
         User::factory()->create([
             'name' => 'Hussein K. Abu Eliewa',
             'email' => '7osain@mail.ps',
             'password' => '1',
         ]);
         User::factory(10)->create();

         $this->call([
             AppListSeeder::class,
             SectionSeeder::class,
             TaskSeeder::class,
             TaskItemSeeder::class,
         ]);
    }
}
