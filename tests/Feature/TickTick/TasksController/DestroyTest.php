<?php

use App\Models\Task;
use App\Models\User;

it('can delete own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->recycle($user)->create();

    login($user)
        ->delete(route('tasks.destroy', $task))
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(Task::query()->count())->toBe(0);
});

it('cannot delete not owned task', function () {
    $task = Task::factory()->create();
    $user = User::factory()->create();

    login($user)
        ->delete(route('tasks.destroy', $task))
        ->assertStatus(403);
});
