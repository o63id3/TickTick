<?php

use App\Models\AppList;
use App\Models\User;

it('can delete own list', function () {
    $user = User::factory()->create();
    $list = AppList::factory()->recycle($user)->create();

    login($user)
        ->delete(route('lists.destroy', $list))
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(AppList::query()->count())->toBe(0);
});

it('cannot delete not owned list', function () {
    $list = AppList::factory()->create();
    $user = User::factory()->create();

    login($user)
        ->delete(route('lists.destroy', $list))
        ->assertStatus(403);
});
