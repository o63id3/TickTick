<?php

use App\Models\AppList;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

uses(WithFaker::class);


it('can store new section', function () {
    $user = User::factory()->create();
    $list = AppList::factory()->recycle($user)->create();

    login($user)
        ->post(route('list.sections.store', $list), [
            'name' => $this->faker->name(),
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(Section::query()->latest()->first())
        ->list_id->tobe($list->id)
        ->name->toBeString()->not->toBeEmpty();
});

it('cannot store new section for guest user', function () {
    $list = AppList::factory()->create();
    $this->post(route('list.sections.store', $list))
        ->assertRedirect('login');

    expect(Section::query()->count())->toBe(0);
});

it('validates the name field', function ($name) {
    $user = User::factory()->create();
    $list = AppList::factory()->recycle($user)->create();

    login($user)
        ->post(route('list.sections.store', $list), [
            'name' => $name,
        ])
        ->assertSessionHasErrors(['name']);
})->with([
    '',
    '1',
    1,
    Str::random(256),
]);

it('cannot store new section for not owned list', function () {
    $list = AppList::factory()->create();

    login()
        ->post(route('list.sections.store', $list))
        ->assertStatus(403);
});
