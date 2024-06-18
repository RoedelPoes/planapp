<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $events = array();
        $todos = Todo::where('user_id', Auth::id())->get();

        return view('todo.todo')->with(['todos' => $todos]);
    }
}
