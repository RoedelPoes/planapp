<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>
    @vite('resources/css/app.css')

</head>


<body class="font-sans antialiased dark:bg-black dark:text-white/50">

    <x-app-layout>

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Home') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <h1 class="text-2xl">Welcome {{ $name }}, today is <span
                        class="text-white">{{ $currentDay }}</span> </h1>
                <div class="h-auto w-full bg-slate-800 rounded mt-5 py-4">
                    <h2 class="ml-6 mb-6 mt-2 pb-0 text-white text-2xl">Upcoming appointments:</h2>
                    <div class="flex flex-col gap-5">
                        <!-- Display upcoming appointments -->
                        @forelse ($upcomingAppointments as $appointment)
                        <div class="flex gap-0 h-max mx-6">
                            <div class="bg-[{{ $appointment->color }}]/100 w-3 rounded-l-md"></div>
                            <a href="{{ url('calendar') }}"
                                class="h-auto w-auto m-0 rounded-r-md bg-gray-600 w-full">
                                <p class="text-gray-200 ml-4 mt-2">{{ $appointment->title }}</p>


                                <!-- Check if the appointment is an all day event -->
                                @if (
                                    \Carbon\Carbon::parse($appointment->start_date)->format('H:i') === '00:00' &&
                                        \Carbon\Carbon::parse($appointment->end_date)->format('H:i') === '23:59')
                                    <p class="ml-4 mb-2 text-gray-200">
                                        {{ \Carbon\Carbon::parse($appointment->start_date)->format('F jS') }} | All Day
                                    </p>
                                @else
                                    <p class="ml-4 mb-2 text-gray-200">
                                        {{ \Carbon\Carbon::parse($appointment->start_date)->format('F jS') }} |
                                        {{ \Carbon\Carbon::parse($appointment->start_date)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($appointment->end_date)->format('h:i A') }}</p>
                                @endif
                            </a>

                        </div>


                            <!-- If there are no upcoming appointments -->
                        @empty
                            <p class="text-gray-300 ml-6 mt-2">No upcoming appointments.</p>
                        @endforelse
                    </div>
                </div>

                <div class="h-auto w-full bg-slate-800 rounded mt-5 py-4">
                    <h2 class="ml-6 mb-6 mt-2 pb-0 text-white text-2xl">Todays tasks:</h2>
                    <ul class="list-disc list-inside">
                    @forelse ($todaysTodos as $todo)
                    <li class="bg-gray-600 rounded-md mt-2 md-2 flex mx-6">
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
                            <p class="text-gray-300 ml-6 mt-2">No tasks for today.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </x-app-layout>

</body>

</html>
