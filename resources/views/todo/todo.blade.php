<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">

    <x-app-layout>

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('To-do') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="h-auto w-full rounded mt-5 py-4">
                    <h2 class="ml-6 mb-2 pb-0 text-white text-2xl">Todays tasks:</h2>
                    <ul class="list-disc list-inside">
                        @foreach ($todos as $todo)
                        <li class="flex items-center justify-between p-2 border border-gray-300 rounded-md mt-2 md-2 ">
                            <form action="/todo/{{ $todo->id }}/complete" method="POST" class="flex items-center">
                                <input type="checkbox" {{ $todo->completed ? 'checked' : '' }} onclick="this.form.submit()" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-pink-600 shadow-sm focus:ring-pink-500 dark:focus:ring-pink-600 dark:focus:ring-offset-gray-800">
                            </form>
                            <span class="{{ $todo->completed ? 'line-through' : '' }} text-white">{{ $todo->title }}</span>
                            <form action="/todo/{{ $todo->id }}/delete" method="POST">
                                <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </x-app-layout>

</body>

</html>

