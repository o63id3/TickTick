<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListResource;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Models\AppList;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        $lists = auth()->user()
            ->lists()
            ->withCount('uncompletedTasks')
            ->get();

        return inertia('Lists/Index', [
            'lists' => ListResource::collection($lists),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AppList $list): \Inertia\Response
    {
        return Inertia::render('Lists/Show', [
            'list' => new ListResource($list),
            'sections' => SectionResource::collection($list->sections()->withCount('uncompletedTasks')->with(['tasks', 'tasks.items'])->get()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
