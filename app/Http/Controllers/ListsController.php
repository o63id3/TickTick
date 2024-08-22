<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListResource;
use App\Models\AppList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Response;
use Inertia\ResponseFactory;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|ResponseFactory
    {
        $lists = auth()->user()
            ->lists()
            ->withCount('uncompletedTasks')
            ->latest()
            ->paginate(12);

        return inertia('Lists/Index', [
            'lists' => ListResource::collection($lists),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['sometimes', 'string', 'max:1024'],
        ]);

        $request->user()->lists()->create($validated);

        return back()->with('success', 'List created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppList $list): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['sometimes', 'string', 'max:1024'],
        ]);

        $list->update($validated);

        return back()->with('success', 'List updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppList $list): RedirectResponse
    {
        $list->delete();

        return back()->with('success', 'List deleted successfully!');
    }
}
