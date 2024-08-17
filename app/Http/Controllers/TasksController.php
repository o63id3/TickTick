<?php

namespace App\Http\Controllers;

use App\Enums\TaskPriority;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class TasksController extends Controller
{
    /**
     * Toggle the specified resource completed in storage.
     */
    public function toggle(Task $task, Request $request)
    {
        if (!$task->completed) {
            $task->items()->update(['completed' => true]);
        }

        $task->update([
            'completed' => !$task->completed
        ]);

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255', 'min:3'],
            'description' => ['sometimes', 'string', 'max:255', 'min:3'],
            'priority' => ['sometimes', new Enum(TaskPriority::class)],
        ]);

        $task->update($validated);

        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return back();
    }

}
