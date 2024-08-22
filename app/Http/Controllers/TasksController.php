<?php

namespace App\Http\Controllers;

use App\Enums\TaskPriority;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Inertia\Response;
use Inertia\ResponseFactory;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response|ResponseFactory
    {
        return inertia('Tasks/Index', [
            'tasks' => [
                'recentlyCreated' => TaskResource::collection(
                    $request->user()->recentlyCreatedTasks()->take(6)->get()
                ),
                'recentlyCompleted' => TaskResource::collection(
                    $request->user()->recentlyCompletedTasks()->take(6)->get()
                ),
                'notCompleted' => TaskResource::collection(
                    $request->user()->uncompletedTasks()->take(6)->get()
                ),
                'highPriority' => TaskResource::collection(
                    $request->user()->highPriorityTasks()->take(6)->get()
                ),
            ],
        ]);
    }

    /**
     * Toggle the specified resource completed in storage.
     */
    public function toggle(Task $task, Request $request): RedirectResponse
    {
        if ($task->completed_at === null) {
            $task->items()->update(['completed_at' => now()]);

            $task->update([
                'completed_at' => now()
            ]);
        } else {
            $task->update([
                'completed_at' => null
            ]);
        }

        return back()->with('success', 'Task toggled successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255', 'min:3'],
            'description' => ['sometimes', 'string', 'max:255', 'min:3'],
            'priority' => ['sometimes', new Enum(TaskPriority::class)],
        ]);

        $task->update($validated);

        return back()->with('success', 'Task updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully!');
    }

}
