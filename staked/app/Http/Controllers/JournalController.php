<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
   

    public function create()
    {
        return view('backend.journals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'summary' => 'nullable|string',
            'thoughts' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();

        Journal::create($data);

        return redirect()->route('journals.index')->with('success', 'Journal created!');
    }

    public function edit(Journal $journal)
    {
        $this->authorize('update', $journal); // optional policy
        return view('backend.journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $data = $request->validate([
            'summary' => 'nullable|string',
            'thoughts' => 'nullable|string',
        ]);

        $journal->update($data);

        return redirect()->route('journals.index')->with('success', 'Journal updated!');
    }

    public function show(Journal $journal)
    {
        $this->authorize('view', $journal); // optional if using policies
        return view('backend.journals.show', compact('journal'));
    }




    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal); // optional policy
        $journal->delete();

        return redirect()->route('journals.index')->with('success', 'Journal deleted!');
    }

    public function kalendar()
    {
        $journals = Journal::where('user_id', auth()->id())->get(['id', 'date', 'summary']);

       

        return view('backend.journals.calendar', compact('journals'));
    }

     public function index()
    {
        $journals = Journal::where('user_id', Auth::id())
                           ->orderByDesc('date')
                           ->paginate(10);

        return view('backend.journals.index', compact('journals'));
    }

}


