<?php

namespace App\Http\Controllers;

use App\Models\AppList;
use Illuminate\Http\Request;

class ListSectionsController extends Controller
{
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
