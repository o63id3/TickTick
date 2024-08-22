<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::all();

        TaskItem::factory($tasks->count() * 2)->recycle($tasks)->create();
    }
}
