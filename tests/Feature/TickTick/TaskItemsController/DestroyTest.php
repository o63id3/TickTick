<?php

use App\Models\TaskItem;
use App\Models\User;

it('can delete own item', function () {
    $user = User::factory()->create();
    $item = TaskItem::factory()->recycle($user)->create();

    login($user)
        ->delete(route('items.destroy', $item))
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(TaskItem::query()->count())->toBe(0);
});

it('cannot delete not owned item', function () {
    $task = TaskItem::factory()->create();
    $user = User::factory()->create();

    login($user)
        ->delete(route('items.destroy', $task))
        ->assertStatus(403);
});
