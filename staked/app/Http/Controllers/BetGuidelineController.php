<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BetGuideline;

class BetGuidelineController extends Controller
{
    public function index()
    {
        $guidelines = BetGuideline::orderBy('type')->orderBy('id')->get();
        return view('backend.routine.index', compact('guidelines'));
    }

    public function create()
    {
        return view('backend.routine.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:routine,rule',
            'title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        BetGuideline::create($data);

        return redirect()->route('bet-guidelines.index')->with('success', 'Guideline created successfully');
    }

    public function edit(BetGuideline $betGuideline)
    {
        return view('backend.routine.create', compact('betGuideline'));
    }

    public function update(Request $request, BetGuideline $betGuideline)
    {
        $data = $request->validate([
            'type' => 'required|in:routine,rule',
            'title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $betGuideline->update($data);

        return redirect()->route('bet-guidelines.index')->with('success', 'Guideline updated successfully');
    }

    public function destroy(BetGuideline $betGuideline)
    {
        $betGuideline->delete();
        return redirect()->route('bet-guidelines.index')->with('success', 'Guideline deleted successfully');
    }
}
