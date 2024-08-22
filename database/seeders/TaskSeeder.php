<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = Section::all();

        Task::factory($sections->count() * 15)->recycle($sections)->create();
    }
}
