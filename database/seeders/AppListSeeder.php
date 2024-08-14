<?php

namespace Database\Seeders;

use App\Models\AppList;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        AppList::factory(20)->recycle($users)->create();
    }
}
