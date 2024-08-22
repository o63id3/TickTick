<?php

namespace App\Http\Controllers;

use App\Enums\TaskPriority;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class SectionTasksController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Section $section, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'max:255', 'min:3'],
            'priority' => ['required', new Enum(TaskPriority::class)],
        ]);

        $section->tasks()->create($validated);

        return back();
    }
}
