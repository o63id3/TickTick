<?php

use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Str;

it('can update own section', function () {
    $user = User::factory()->create();
    $section = Section::factory()->recycle($user)->create();

    login($user)
        ->put(route('sections.update', $section), [
            'name' => 'this is updated name',
            'description' => 'this is updated description',
        ])
        ->assertSessionHasNoErrors();

    expect(Section::query()->latest()->first())
        ->name->toBe('this is updated name');
});

it('cannot update not owned section', function () {
    $user = User::factory()->create();
    $section = Section::factory()->create();

    login($user)
        ->put(route('sections.update', $section))
        ->assertStatus(403);
});

it('validates updated section name', function ($name) {
    $user = User::factory()->create();
    $section = Section::factory()->recycle($user)->create();

    login($user)
        ->put(route('sections.update', $section), [
            'name' => $name,
            'description' => Str::random(1025),
        ])
        ->assertSessionHasErrors(['name']);
})->with([
    '',
    '1',
    1,
    Str::random(256),
]);
