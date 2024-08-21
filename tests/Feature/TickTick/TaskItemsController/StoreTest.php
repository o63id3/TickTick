<?php

use App\Models\Task;
use App\Models\TaskItem;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

uses(WithFaker::class);

it('can store new task item', function () {
    $user = User::factory()->create();
    $task = Task::factory()->recycle($user)->create();

    login($user)
        ->post(route('task.items.store', $task), [
            'title' => $this->faker->words(3, true),
        ]);

    expect(TaskItem::query()->latest()->first())
        ->task_id->tobe($task->id)
        ->title->toBeString()->not->toBeEmpty();
});

it('cannot store new task for guest user', function () {
    $task = Task::factory()->create();

    $this->post(route('task.items.store', $task))
        ->assertRedirect('login');

    expect(TaskItem::query()->count())->toBe(0);
});

it('cannot store new task item for not owned task', function () {
    $task = Task::factory()->create();

    login()
        ->post(route('task.items.store', $task))
        ->assertStatus(403);

    expect(TaskItem::query()->count())->toBe(0);
});

it('validates the input fields', function ($title) {
    $user = User::factory()->create();
    $task = Task::factory()->recycle($user)->create();

    login($user)
        ->post(route('task.items.store', $task), [
            'title' => $title,
        ])
        ->assertSessionHasErrors(['title']);
})->with([
    '',
    1,
    Str::random(256),
    Str::random(256),
]);
