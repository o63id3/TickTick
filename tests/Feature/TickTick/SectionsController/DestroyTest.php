<?php

use App\Models\Section;
use App\Models\User;

it('can delete own section', function () {
    $user = User::factory()->create();
    $section = Section::factory()->recycle($user)->create();

    login($user)
        ->delete(route('sections.destroy', $section))
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(Section::query()->count())->toBe(0);
});

it('cannot delete not owned list', function () {
    $section = Section::factory()->create();
    $user = User::factory()->create();

    login($user)
        ->delete(route('sections.destroy', $section))
        ->assertStatus(403);
});
