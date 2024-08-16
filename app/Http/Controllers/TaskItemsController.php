<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskItemsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Task $task, Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
        ]);

        $task->items()->create($validated);

        return back();
    }
}
