<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>To-do</title>
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">

    <x-app-layout>

    <!-- Insert Modal -->
    <div id="todoModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75 
    @if (!$errors->any())
    hidden
    @endif
    ">
        <form action="{{ route('todo.store') }}" method="post" class="bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            @csrf
            <div class="bg-gray-700 px-4 py-4">

                <div id="Radio-buttons" class="flex bg-gray-700 w-full gap-5 mt-5 mb-5">
                    <div class="flex ">
                        <input type="radio" id="cyan-tag" name="tagColor" value="cyan" class="hidden peer"
                            checked="checked" />
                        <label for="cyan-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-cyan-400 peer-checked:text-cyan-400 hover:text-gray-600 hover:bg-gray-900">
                            Cyan
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="green-tag" name="tagColor" value="green" class="hidden peer" />
                        <label for="green-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:text-green-500 hover:text-gray-600 hover:bg-gray-900">
                            Green
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="yellow-tag" name="tagColor" value="yellow" class="hidden peer" />
                        <label for="yellow-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-yellow-500 peer-checked:text-yellow-500 hover:text-gray-600 hover:bg-gray-900">
                            Yellow
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="purple-tag" name="tagColor" value="purple" class="hidden peer" />
                        <label for="purple-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-purple-500 peer-checked:text-purple-500 hover:text-gray-600 hover:bg-gray-900">
                            Purple
                        </label>
                    </div>
                </div>

                <label for="title" class="text-white m-2 mt-2 block">Task</label>
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <span id="titleError" class="text-red-500 w-full block">{{$error}}</span>
                @endforeach
                @endif
                <input type="text"
                    class="w-full px-3 py-2 mb-3 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                    id="title" name="title" placeholder="Enter your task">

                <div class="flex justify-between">
                    <div class="w-full mr-2">
                        <label for="start_time" class="text-white m-2 block">Date</label>
                        <input type="date"
                            class="w-full px-3 py-2 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                            id="date" name="date">
                    </div>
                </div>
            </div>
            <div class="bg-gray-700 px-4 py-3 pb-6 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" id="saveBtn"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400 sm:ml-3 sm:w-auto sm:text-sm">
                    Create task
                </button>
                <button type="button" id="closeBtn"
                    class="w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </form>
    </div>

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('To-do') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto mt-5 sm:px-6 lg:px-8">
                <div class="flex justify-between pt-4">
                    <h1 class="text-2xl">Hello <span class="text-white">{{ $name }}</span> here are you
                        notes,</h1>
                    <div class="flex gap-10">
                        <button id="addTask"
                            class="text-l bg-pink-500 px-4 py-2 rounded text-white hover:bg-pink-600">Create
                            To-Do</button>
                    </div>
                </div>
                <div class="h-auto w-full rounded py-4">

                    @if ($missedTodos->isNotEmpty())
                    <h2 class="mt-10 mb-6 pb-0 text-white text-2xl">Missed tasks:</h2>
                    <ul class="list-disc list-inside">
                        @foreach ($missedTodos as $todo)
                        <li class="bg-gray-800 border border-red-700 rounded-md mt-2 md-2 flex">
                            <div class="bg-{{$todo->tagColor}}-400 w-3 h-10 rounded-l-md"></div>
                            <div class="flex items-center justify-between p-2 w-full">
                                <form action="/todo/complete/{{ $todo->id }}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="checkbox" {{ $todo->completed ? 'checked' : '' }} onclick="this.form.submit()" class="h-5 w-5 rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-pink-600 shadow-sm focus:ring-pink-500 dark:focus:ring-pink-600 dark:focus:ring-offset-gray-800">
                                </form>
                                <span class="{{ $todo->completed ? 'line-through' : '' }} text-white">{{ $todo->title }}</span>
                                <form action="/todo/destroy/{{ $todo->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    <h2 class="mt-10 mb-6 pb-0 text-white text-2xl">Todays tasks:</h2>
                    <ul class="list-disc list-inside">
                        @forelse ($todaysTodos as $todo)
                        <li class="bg-gray-600 {{ $todo->completed ? 'bg-gray-600' : 'bg-gray-800' }} rounded-md mt-2 md-2 flex">
                            <div class="bg-{{ $todo->tagColor }}-400 w-3 h-10 rounded-l-md"></div>
                            <div class="flex items-center justify-between p-2 w-full">
                            <form action="/todo/complete/{{ $todo->id }}" method="POST" class="flex items-center">
                                @csrf
                                <input type="checkbox" {{ $todo->completed ? 'checked' : '' }} onclick="this.form.submit()" class="h-5 w-5 rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-pink-600 shadow-sm focus:ring-pink-500 dark:focus:ring-pink-600 dark:focus:ring-offset-gray-800">
                            </form>
                            <span class="{{ $todo->completed ? 'line-through text-gray-400' : 'text-white' }}">{{ $todo->title }}</span>
                            <form action="/todo/destroy/{{ $todo->id }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                            </form>
                        </li>
                        @empty
                            <p class="text-lg">No tasks for today yet...</p>
                        @endforelse

                    </ul>

                    <h2 class="mt-10 mb-6 pb-0 text-white text-2xl">Upcoming tasks:</h2>
                    <ul class="list-disc list-inside">
                        @forelse ($upcomingTodos as $todo)
                        <li class="bg-gray-600 {{ $todo->completed ? 'bg-gray-600' : 'bg-gray-800' }} rounded-md mt-2 md-2 flex">
                            <div class="bg-{{ $todo->tagColor }}-400 w-3 h-10 rounded-l-md"></div>
                            <div class="flex items-center justify-between p-2 w-full">
                            <form action="/todo/complete/{{ $todo->id }}" method="POST" class="flex items-center">
                                @csrf
                                <input type="checkbox" {{ $todo->completed ? 'checked' : '' }} onclick="this.form.submit()" class="h-5 w-5 rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-pink-600 shadow-sm focus:ring-pink-500 dark:focus:ring-pink-600 dark:focus:ring-offset-gray-800">
                            </form>
                            <span class="{{ $todo->completed ? 'line-through text-gray-400' : 'text-white' }}">{{ $todo->title }}</span>
                            <form action="/todo/destroy/{{ $todo->id }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                            </form>
                        </li>
                        @empty
                            <p class="text-lg">No upcoming tasks yet...</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </x-app-layout>
    
</body>

<script>
 
    // Open booking modal
    $('#addTask').on('click', function() {
        $('#todoModal').removeClass('hidden');
    });

    // Close booking modal
    $('#closeBtn').on('click', function() {
        $('#todoModal').addClass('hidden');
    });
</script>

</html>

