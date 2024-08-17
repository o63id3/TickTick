<?php

namespace App\Policies;

use App\Models\TaskItem;
use App\Models\User;

class TaskItemPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskItem $item): bool
    {
        return $user->id === $item->task->section->list->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function toggleComplete(User $user, TaskItem $item): bool
    {
        return $user->id === $item->task->section->list->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskItem $item): bool
    {
        return $user->id === $item->task->section->list->user_id;
    }
}
