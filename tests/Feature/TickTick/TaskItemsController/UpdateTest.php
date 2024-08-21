<?php

use App\Models\TaskItem;
use App\Models\User;
use Illuminate\Support\Str;

it('can update own item', function () {
    $user = User::factory()->create();
    $item = TaskItem::factory()->recycle($user)->create();

    login($user)
        ->put(route('items.update', $item), [
            'title' => 'this is updated title',
        ])
        ->assertSessionHasNoErrors();

    expect(TaskItem::query()->latest()->first())
        ->title->toBe('this is updated title');
});

it('cannot update not owned item', function () {
    $user = User::factory()->create();
    $item = TaskItem::factory()->create();

    login($user)
        ->put(route('items.update', $item))
        ->assertStatus(403);
});

it('validates to be updated item title', function ($title) {
    $user = User::factory()->create();
    $item = TaskItem::factory()->recycle($user)->create();

    login($user)
        ->put(route('items.update', $item), [
            'title' => $title,
        ])
        ->assertSessionHasErrors(['title']);
})->with([
    '',
    '1',
    1,
    Str::random(256),
]);
