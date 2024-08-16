<?php

use App\Http\Controllers\ListsController;
use App\Http\Controllers\ListSectionsController;
use App\Http\Controllers\SectionTasksController;
use App\Http\Controllers\TaskItemsController;
use App\Http\Controllers\TasksController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Lists
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/lists', [ListsController::class, 'index'])->name('lists.index');
    Route::get('/lists/{list}', [ListsController::class, 'show'])->name('lists.show');
    Route::post('/lists', [ListsController::class, 'store'])->name('lists.store');

    Route::post('/lists/{list}/sections', [ListSectionsController::class, 'store'])->name('list.sections.store');
});

// Sections
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/sections/{section}/tasks', [SectionTasksController::class, 'store'])->name('section.tasks.store');
});

// Tasks
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/tasks/{task}/items', [TaskItemsController::class, 'store'])->name('task.items.store');
    Route::put('/tasks/{task}', [TasksController::class, 'toggle'])->name('tasks.toggle.completed');

    Route::put('/items/{item}', [TaskItemsController::class, 'toggle'])->name('items.toggle.completed');
});
