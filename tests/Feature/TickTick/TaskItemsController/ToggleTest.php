<?php

use App\Models\TaskItem;
use App\Models\User;

it('can toggle own item', function () {
    $user = User::factory()->create();
    $item = TaskItem::factory()->recycle($user)->create(['completed_at' => null]);

    login($user)
        ->put(route('items.toggle.completed', $item))
        ->assertSessionHasNoErrors();


    expect(TaskItem::query()->latest()->first())
        ->completed_at->not->toBeNull();

    login($user)
        ->put(route('items.toggle.completed', $item))
        ->assertSessionHasNoErrors();

    expect(TaskItem::query()->latest()->first())
        ->completed_at->toBeNull();
});

it('cannot toggle not owned item', function () {
    $user = User::factory()->create();
    $item = TaskItem::factory()->create();

    login($user)
        ->put(route('items.toggle.completed', $item))
        ->assertStatus(403);
});
