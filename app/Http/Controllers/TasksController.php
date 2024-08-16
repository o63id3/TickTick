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
        $task->update([
            'completed' => !$task->completed
        ]);

        return back();
    }
}
