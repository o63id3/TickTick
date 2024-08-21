<?php

use App\Models\Task;
use App\Models\TaskItem;
use App\Models\User;

it('can toggle own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->recycle($user)->create(['completed_at' => null]);

    login($user)
        ->put(route('tasks.toggle.completed', $task))
        ->assertSessionHasNoErrors();

    expect(Task::query()->latest()->first())
        ->completed_at->not->toBeNull();

    login($user)
        ->put(route('tasks.toggle.completed', $task))
        ->assertSessionHasNoErrors();

    expect(Task::query()->latest()->first())
        ->completed_at->toBeNull();
});

it('completes all task items', function () {
    $user = User::factory()->create();
    $task = Task::factory()->recycle($user)->create(['completed_at' => null]);
    TaskItem::factory(10)->recycle($task)->create(['completed_at' => null]);

    login($user)
        ->put(route('tasks.toggle.completed', $task))
        ->assertSessionHasNoErrors();

    expect(TaskItem::query()->whereNotNull('completed_at')->count())->toBe(10);
});

it('cannot toggle not owned task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create();

    login($user)
        ->put(route('tasks.toggle.completed', $task))
        ->assertStatus(403);
});
