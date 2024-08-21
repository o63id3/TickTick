<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;

it('can update own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->recycle($user)->create(['priority' => 'High']);

    login($user)
        ->put(route('tasks.update', $task), [
            'title' => 'this is updated title',
            'description' => 'this is updated description',
            'priority' => 'None',
        ])
        ->assertSessionHasNoErrors();

    expect(Task::query()->latest()->first())
        ->title->toBe('this is updated title')
        ->description->toBe('this is updated description')
        ->priority->value->toBe('None');
});

it('cannot update not owned task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create();

    login($user)
        ->put(route('tasks.update', $task))
        ->assertStatus(403);
});

it('validates the input fields', function ($title, $description, $priority) {
    $user = User::factory()->create();
    $task = Task::factory()->recycle($user)->create();

    login($user)
        ->put(route('tasks.update', $task), [
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
        ])
        ->assertSessionHasErrors(['title', 'description', 'priority']);
})->with([
    ['', '', ''],
    [1, 1, 1],
    [Str::random(256), Str::random(256), 1],
    [Str::random(256), Str::random(256), 'NotValidPriority'],
]);

