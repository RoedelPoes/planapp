<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Console\View\Components\Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $currentDay = Carbon::now()->format('Y-m-d') . ' 00:00:00';

        $missedTodos = Todo::where('user_id', Auth::id())
        ->where('date', '<', $currentDay)
        ->where('completed', '0')->get();

        $todaysTodos = Todo::where('user_id', Auth::id())
        ->where('date', '=', $currentDay)->get();

        $upcomingTodos = Todo::where('user_id', Auth::id())->orderBy('date')
        ->where('date', '>', $currentDay)->get();

        return view('todo.todo')
        ->with(['missedTodos' => $missedTodos,'todaysTodos' => $todaysTodos, 'upcomingTodos' => $upcomingTodos, 'currentDay' => $currentDay]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'date' => 'required|date|before:31-12-9999',
        ]);

        Todo::create([
            'title' => $request->title,
            'date' => $request->date,
            'completed' => 0,
            'tagColor' => $request->tagColor,
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

        if ($todo['completed'] == 1) {
            $completed = ['completed' => 0];
        } else {
            $completed = ['completed' => 1];
        }

        $todo->update($completed);

        return redirect()->route('todo');
    }
}
