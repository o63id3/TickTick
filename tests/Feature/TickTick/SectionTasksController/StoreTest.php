<?php

use App\Models\Section;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;

uses(\Illuminate\Foundation\Testing\WithFaker::class);

it('can store new task', function () {
    $user = User::factory()->create();
    $section = Section::factory()->recycle($user)->create();

    login($user)
        ->post(route('section.tasks.store', $section), [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'priority' => $this->faker->randomElement(array_column(\App\Enums\TaskPriority::cases(), 'value')),
        ]);

    expect(Task::query()->latest()->first())
        ->section_id->tobe($section->id)
        ->title->toBeString()->not->toBeEmpty()
        ->description->toBeString()->not->toBeEmpty()
        ->priority->value->toBeIn(array_column(\App\Enums\TaskPriority::cases(), 'value'));
});

it('cannot store new task for guest user', function () {
    $section = Section::factory()->create();

    $this->post(route('section.tasks.store', $section), [
        'name' => $this->faker->words(3, true),
        'description' => $this->faker->sentence(3),
    ])
        ->assertRedirect('login');

    expect(Task::query()->count())->toBe(0);
});

it('cannot store new task for not owned section', function () {
    $section = Section::factory()->create();

    login()
        ->post(route('section.tasks.store', $section))
        ->assertStatus(403);

    expect(Task::query()->count())->toBe(0);
});

it('validates the input fields', function ($title, $description, $priority) {
    $user = User::factory()->create();
    $section = Section::factory()->recycle($user)->create();

    login($user)
        ->post(route('section.tasks.store', $section), [
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
        ])
        ->assertSessionHasErrors(['title', 'description', 'priority']);
})->with([
    ['', '', ''],
    [1, 1, 1],
    [Str::random(256), Str::random(256), 1],
    [Str::random(256), Str::random(256), 'NotValidPriority'],
]);
