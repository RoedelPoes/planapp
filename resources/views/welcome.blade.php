<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


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

                <h1 class="text-2xl">Welcome {{$name}}, today is <span class="text-white">{{$currentDay}}</span> </h1>
                <div class="h-auto w-full bg-pink-400 rounded mt-5 py-4">
                    <h2 class="ml-6 mb-2 pb-0 text-white text-2xl">Upcomming appointments:</h2>
                    <div class="flex flex-col">
                        <!-- Display upcoming appointments -->
                        @forelse ($upcomingAppointments as $appointment)
                            <a href="{{ url('calendar') }}" class="mx-6 my-2 h-auto w-auto m-0 bg-pink-700 rounded">
                                <p class="text-white ml-4 mt-2">{{ $appointment->title }}</p>
                                <!-- Check if the appointment is an all day event -->
                                @if (\Carbon\Carbon::parse($appointment->start_date)->format('H:i') === '00:00' && \Carbon\Carbon::parse($appointment->end_date)->format('H:i') === '23:59')
                                    <p class="ml-4 mb-2">{{ \Carbon\Carbon::parse($appointment->start_date)->format('F jS') }} | All Day</p>
                                @else
                                    <p class="ml-4 mb-2">{{ \Carbon\Carbon::parse($appointment->start_date)->format('F jS') }} | {{ \Carbon\Carbon::parse($appointment->start_date)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_date)->format('h:i A') }}</p>
                                @endif
                        </a>
                        <!-- If there are no upcoming appointments -->
                        @empty
                            <p class="text-gray-300 ml-6 mt-2">No upcoming appointments.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </x-app-layout>

</body>

</html>
