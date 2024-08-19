<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListResource;
use App\Http\Resources\SectionResource;
use App\Models\AppList;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AppList $list): \Inertia\Response
    {
        $sections = $list
            ->sections()
            ->withCount('uncompletedTasks')
            ->with(['tasks', 'tasks.items'])
            ->orderBy('uncompleted_tasks_count', 'desc')
            ->get();

        return Inertia::render('Lists/Sections/Index', [
            'list' => new ListResource($list),
            'sections' => SectionResource::collection($sections),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppList $list, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
        ]);

        $list->sections()->create($validated);

        return back();
    }
}
