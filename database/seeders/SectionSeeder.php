<?php

namespace Database\Seeders;

use App\Models\AppList;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lists = AppList::all();

        Section::factory(100)->recycle($lists)->create();
    }
}
