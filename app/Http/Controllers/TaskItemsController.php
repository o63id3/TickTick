<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskItemsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Task $task, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
        ]);

        $task->items()->create($validated);

        return back()->with('success', 'Item created successfully!');
    }

    /**
     * Toggle the specified resource completed in storage.
     */
    public function toggle(TaskItem $item, Request $request): RedirectResponse
    {
        if ($item->completed_at === null) {
            $item->update([
                'completed_at' => now()
            ]);
        } else {
            $item->update([
                'completed_at' => null
            ]);
        }

        return back()->with('success', 'Item toggled successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskItem $item): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
        ]);

        $item->update($validated);

        return back()->with('success', 'Item updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskItem $item): RedirectResponse
    {
        $item->delete();

        return back()->with('success', 'Item deleted successfully!');
    }

}
