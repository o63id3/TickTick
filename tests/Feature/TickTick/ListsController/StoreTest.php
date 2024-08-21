<?php

use App\Models\AppList;
use App\Models\User;
use Illuminate\Support\Str;

uses(\Illuminate\Foundation\Testing\WithFaker::class);

it('can store new list', function () {
    $user = User::factory()->create();

    login($user)
        ->post(route('lists.store'), [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
        ]);

    expect(AppList::query()->latest()->first())
        ->user_id->tobe($user->id)
        ->name->toBeString()->not->toBeEmpty()
        ->description->toBeString()->not->toBeEmpty();
});

it('cannot store new list for guest user', function () {
    $this->post(route('lists.store'), [
        'name' => $this->faker->words(3, true),
        'description' => $this->faker->sentence(3),
    ])
        ->assertRedirect('login');

    expect(AppList::query()->count())->toBe(0);
});

it('validates the name and description field', function ($name) {
    login()
        ->post(route('lists.store'), [
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
