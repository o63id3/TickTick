<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
        ]);

        $section->update($validated);

        return back()->with('success', 'Section updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section): RedirectResponse
    {
        $section->delete();

        return back()->with('success', 'Section deleted successfully!');
    }
}
