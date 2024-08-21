<?php

use App\Models\AppList;
use App\Models\User;
use Illuminate\Support\Str;

it('can update own list', function () {
    $user = User::factory()->create();
    $list = AppList::factory()->recycle($user)->create();

    login($user)
        ->put(route('lists.update', $list), [
            'name' => 'this is updated name',
            'description' => 'this is updated description',
        ])
        ->assertSessionHasNoErrors();

    expect(AppList::query()->latest()->first())
        ->name->toBe('this is updated name')
        ->description->toBe('this is updated description');
});

it('cannot update not owned list', function () {
    $user = User::factory()->create();
    $list = AppList::factory()->create();

    login($user)
        ->put(route('lists.update', $list))
        ->assertStatus(403);
});

it('validates updated list name and description', function ($name) {
    $user = User::factory()->create();
    $list = AppList::factory()->recycle($user)->create();

    login($user)
        ->put(route('lists.update', $list), [
            'name' => $name,
            'description' => Str::random(1025),
        ])
        ->assertSessionHasErrors(['name', 'description']);
})->with([
    '',
    '1',
    1,
    Str::random(256),
]);
