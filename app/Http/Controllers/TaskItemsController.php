<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskItem;
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

    /**
     * Toggle the specified resource completed in storage.
     */
    public function toggle(TaskItem $item, Request $request)
    {
        $item->update([
            'completed' => !$item->completed
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskItem $item)
    {
        $item->delete();

        return back();
    }

}
