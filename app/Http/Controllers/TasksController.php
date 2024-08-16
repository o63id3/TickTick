<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

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
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return back();
    }

}
