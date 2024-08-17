<?php

use App\Http\Controllers\ListsController;
use App\Http\Controllers\ListSectionsController;
use App\Http\Controllers\SectionsController;
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
    Route::put('/lists/{list}', [ListsController::class, 'update'])->name('lists.update');
    Route::delete('/lists/{list}', [ListsController::class, 'destroy'])->name('lists.destroy');

    Route::post('/lists/{list}/sections', [ListSectionsController::class, 'store'])->name('list.sections.store');
});

// Sections
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/sections/{section}', [SectionsController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{section}', [SectionsController::class, 'destroy'])->name('sections.destroy');

    Route::post('/sections/{section}/tasks', [SectionTasksController::class, 'store'])->name('section.tasks.store');
});

// Tasks
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/tasks/{task}', [TasksController::class, 'update'])->name('tasks.update');
    Route::put('/tasks/{task}/complete', [TasksController::class, 'toggle'])->name('tasks.toggle.completed');
    Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->name('tasks.destroy');

    Route::post('/tasks/{task}/items', [TaskItemsController::class, 'store'])->name('task.items.store');

    Route::put('/items/{item}', [TaskItemsController::class, 'update'])->name('items.update');
    Route::put('/items/{item}/toggle', [TaskItemsController::class, 'toggle'])->name('items.toggle.completed');
    Route::delete('/items/{item}', [TaskItemsController::class, 'destroy'])->name('items.destroy');
});
