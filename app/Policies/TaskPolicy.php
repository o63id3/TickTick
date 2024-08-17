<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can add item to the task.
     */
    public function createItem(User $user, Task $task): bool
    {
        return $user->id === $task->section->list->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->section->list->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function toggleComplete(User $user, Task $task): bool
    {
        return $user->id === $task->section->list->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->section->list->user_id;
    }
}
