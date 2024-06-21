<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $colorFilter = $request->input('color-filter');

        // Query notes based on the selected color filter
        $notes = Note::when($colorFilter && $colorFilter !== 'all', function ($query) use ($colorFilter) {
            return $query->where('tagColor', $colorFilter); 
        })
        ->where('user_id', Auth::id())
        ->orderBy('updated_at', 'desc')
        ->get();     

        return view('notes.index')->with(['name' => auth()->user()->name, 'notes' => $notes]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'title' => 'required|string|max:30',
            'content' => 'required|string|max:999',
            'tagColor' => 'required|string', // Takes tailwind color classes
        ]);

        $note = Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'tagColor' => $request->tagColor,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
            'coolor' => $note->tagColor,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $note = Note::where('user_id', Auth::id())->find($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:30',
            'content' => 'required|string|max:999',
            'tagColor' => 'required|string', // Takes tailwind color classes
        ]);

        $updateData = [
            'title' => $request->title,
            'content' => $request->content,
            'tagColor' => $request->tagColor,
        ];

        $note->update($updateData);
        return response()->json([
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
            'color' => $note->tagColor,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $note = Note::where('user_id', Auth::id())->find($id);
        if (!$note) {
            return response()->json([
                'error' => 'Note not found or you do not have permission to delete it'
            ], 404);
        }
        $note->delete();
        return response()->json('Event deleted');
    }
}
