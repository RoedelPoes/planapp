<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->get();

        return view('todo.todo')->with(['todos' => $todos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'date' => 'required|date',
        ]);

        Todo::create([
            'title' => $request->title,
            'date' => $request->date,
            'completed' => 0,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('todo');
    }

    public function destroy($id)
    {
        $todo = Todo::where('user_id', Auth::id())->find($id);

        $todo->delete();

        return redirect()->route('todo');
    }

    public function update($id)
    {
        $todo = Todo::where('user_id', Auth::id())->find($id);

        $completed = ['completed' => 1];
        $todo->update(['completed' => 1]);

        return redirect()->route('todo');
    }
}
