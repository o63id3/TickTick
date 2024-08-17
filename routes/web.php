<?php

use App\Http\Controllers\ListsController;
use App\Http\Controllers\ListSectionsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\SectionTasksController;
use App\Http\Controllers\TaskItemsController;
use App\Http\Controllers\TasksController;
use App\Models\AppList;
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
    Route::get('/lists', [ListsController::class, 'index'])
        ->can('viewAny', AppList::class)
        ->name('lists.index');

    Route::get('/lists/{list}', [ListsController::class, 'show'])
        ->can('view,list')
        ->name('lists.show');

    Route::post('/lists', [ListsController::class, 'store'])
        ->can('create', AppList::class)
        ->name('lists.store');

    Route::put('/lists/{list}', [ListsController::class, 'update'])
        ->can('update,list')
        ->name('lists.update');

    Route::delete('/lists/{list}', [ListsController::class, 'destroy'])
        ->can('destroy,list')
        ->name('lists.destroy');

    Route::post('/lists/{list}/sections', [ListSectionsController::class, 'store'])
        ->can('createSection,list', AppList::class)
        ->name('list.sections.store');
});

// Sections
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/sections/{section}', [SectionsController::class, 'update'])
        ->can('update,section')
        ->name('sections.update');

    Route::delete('/sections/{section}', [SectionsController::class, 'destroy'])
        ->can('delete,section')
        ->name('sections.destroy');

    Route::post('/sections/{section}/tasks', [SectionTasksController::class, 'store'])
        ->can('createTask,section')
        ->name('section.tasks.store');
});

// Tasks
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/tasks/{task}', [TasksController::class, 'update'])
        ->can('update,task')
        ->name('tasks.update');

    Route::put('/tasks/{task}/complete', [TasksController::class, 'toggle'])
        ->can('toggleComplete,task')
        ->name('tasks.toggle.completed');

    Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])
        ->can('delete,task')
        ->name('tasks.destroy');


    Route::post('/tasks/{task}/items', [TaskItemsController::class, 'store'])
        ->can('createItem,task')
        ->name('task.items.store');


    Route::put('/items/{item}', [TaskItemsController::class, 'update'])
        ->can('update,item')
        ->name('items.update');

    Route::put('/items/{item}/toggle', [TaskItemsController::class, 'toggle'])
        ->can('toggleComplete,item')
        ->name('items.toggle.completed');

    Route::delete('/items/{item}', [TaskItemsController::class, 'destroy'])
        ->can('delete,item')
        ->name('items.destroy');
});
