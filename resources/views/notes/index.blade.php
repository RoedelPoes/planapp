<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Notes</title>
    @vite('resources/css/app.css')

    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">

    <x-app-layout>
        <!-- Add Note Modal -->
        <div id="notesModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-75">
            <div
                class="bg-gray-700 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div id="color-tag" class="w-full {{-- bg-fushia-400 --}} h-10"></div>
                <div id="radio-buttons" class="flex bg-gray-700 w-full mt-10 px-5 gap-5">
                    <div class="flex ">
                        <input type="radio" id="pink-tag" name="color-radio" value="fuchsia" class="hidden peer"
                            checked="checked" />
                        <label for="pink-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white   border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-fuchsia-400 peer-checked:text-fuchsia-400 hover:text-gray-600 hover:bg-gray-900">
                            Pink
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="green-tag" name="color-radio" value="green" class="hidden peer" />
                        <label for="green-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:text-green-500 hover:text-gray-600 hover:bg-gray-900">
                            Green
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="yellow-tag" name="color-radio" value="yellow" class="hidden peer" />
                        <label for="yellow-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-yellow-500 peer-checked:text-yellow-500 hover:text-gray-600 hover:bg-gray-900">
                            Yellow
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="purple-tag" name="color-radio" value="purple" class="hidden peer" />
                        <label for="purple-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-purple-500 peer-checked:text-purple-500 hover:text-gray-600 hover:bg-gray-900">
                            Purple
                        </label>
                    </div>
                </div>
                <div class="bg-gray-700 px-4 py-4 mr-2">
                    <label for="title" class="text-white m-2 mt-2 block">Title</label>
                    <input type="text"
                        class="w-full px-3 py-2 mb-3 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                        id="title" placeholder="Event Title">

                    <div class="flex justify-between">
                        <div class="w-full">
                            <label for="note-content" class="text-white m-2 block">Content</label>
                            <textarea rows="10"
                                class="resize-none w-full px-3 py-2 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                                id="note-content" placeholder="Content"></textarea>
                        </div>
                    </div>
                    <span id="titleError" class="text-red-500 w-full block ml-2"></span>
                </div>
                <div class="bg-gray-700 px-4 py-3 pb-6 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="saveBtnNotes"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400 sm:ml-3 sm:w-auto sm:text-sm">
                        Save changes
                    </button>
                    <button type="button" id="closeBtnNotes"
                        class="w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
        <!-- Add Note Modal end -->

        <!-- Edit Note Modal -->
        <div id="editNotesModal"
            class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-75">
            <div
                class="bg-gray-700 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div id="edit-color-tag" class="w-full bg-fuchsia-400 h-10"></div>
                <div id="editRadio-buttons" class="flex bg-gray-700 w-full mt-10 px-5 gap-5">
                    <div class="flex ">
                        <input type="radio" id="edit-pink-tag" name="edit-color-radio" value="fuchsia"
                            class="hidden peer" checked="checked" />
                        <label for="edit-pink-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-fuchsia-400 peer-checked:text-fuchsia-400 hover:text-gray-600 hover:bg-gray-900">
                            Pink
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="edit-green-tag" name="edit-color-radio" value="green"
                            class="hidden peer" />
                        <label for="edit-green-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:text-green-500 hover:text-gray-600 hover:bg-gray-900">
                            Green
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="edit-yellow-tag" name="edit-color-radio" value="yellow"
                            class="hidden peer" />
                        <label for="edit-yellow-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-yellow-500 peer-checked:text-yellow-500 hover:text-gray-600 hover:bg-gray-900">
                            Yellow
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" id="edit-purple-tag" name="edit-color-radio" value="purple"
                            class="hidden peer" />
                        <label for="edit-purple-tag"
                            class="h-min font-semibold text-sm py-1 px-6 bg-transparent text-white border border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-purple-500 peer-checked:text-purple-500 hover:text-gray-600 hover:bg-gray-900">
                            Purple
                        </label>
                    </div>
                </div>
                <div class="bg-gray-700 px-4 py-4 mr-2">
                    <label for="title" class="text-white m-2 mt-2 block">Title</label>
                    <input type="text"
                        class="w-full px-3 py-2 mb-3 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                        id="editTitle" placeholder="Event Title">

                    <div class="flex justify-between">
                        <div class="w-full">
                            <label for="note-content" class="text-white m-2 block">Content</label>
                            <textarea rows="10"
                                class="resize-none w-full px-3 py-2 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                                id="editContent" placeholder="Content"></textarea>
                        </div>
                    </div>
                    <span id="titleError" class="text-red-500 w-full block ml-2"></span>
                </div>
                <div class="bg-gray-700 px-4 py-3 pb-6 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="editSaveBtnNotes" data-id=""
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400 sm:ml-3 sm:w-auto sm:text-sm">
                        Save changes
                    </button>
                    <button type="button" id="deleteEditButton"
                        class="w-full inline-flex justify-center rounded-md border border-red-600 shadow-sm px-4 py-2 bg-red-700 text-base font-medium text-gray-300 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" id="editCloseBtnNotes"
                        class="w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
        <!-- Edit Note Modal end -->

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Notes') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="h-auto w-full rounded mt-5 py-4">
                    <div class="flex justify-between">
                        <h1 class="text-2xl">Hello <span class="text-white">{{ $name }}</span> here are you
                            notes,</h1>
                        <div class="flex gap-10">
                            <button id="create-note"
                                class="text-l bg-pink-500 px-4 py-2 rounded text-white hover:bg-pink-600">Create
                                Note</button>
                                <div class="flex flex-col" >
                                    <button class="text-l px-4 py-2 rounded  cursor-pointer hover:underline" id="filterBtn" >Filter</button>
                                    <!-- Filter Modal -->
                                    <form id="colorFilterForm" action="{{ route('notes') }}" method="GET" class="flex flex-col w-20 text-center z-50 absolute hidden">
                                        <input type="radio" name="color-filter" id="color-filter-all" value="all" checked class="hidden peer/all">
                                        <label for="color-filter-all" class="cursor-pointer py-2 px-4 bg-gray-600 rounded-t-xl peer-checked/all:bg-gray-500">All</label>
                                    
                                        <input type="radio" name="color-filter" id="color-filter-fuchsia" value="fuchsia" class="hidden peer/pink">
                                        <label for="color-filter-fuchsia" class="cursor-pointer py-2 px-4 bg-gray-600  peer-checked/pink:bg-gray-500">Pink</label>
                                    
                                        <input type="radio" name="color-filter" id="color-filter-green" value="green" class="hidden peer/green">
                                        <label for="color-filter-green" class="cursor-pointer py-2 px-4 bg-gray-600  peer-checked/green:bg-gray-500">Green</label>
                                    
                                        <input type="radio" name="color-filter" id="color-filter-yellow" value="yellow" class="hidden peer/yellow">
                                        <label for="color-filter-yellow" class="cursor-pointer py-2 px-4 bg-gray-600  peer-checked/yellow:bg-gray-500">Yellow</label>
                                    
                                        <input type="radio" name="color-filter" id="color-filter-purple" value="purple" class="hidden peer/purple">
                                        <label for="color-filter-purple" class="cursor-pointer py-2 px-4 bg-gray-600 rounded-b-xl peer-checked/purple:bg-gray-500">Purple</label>
                                    </form>
                                </div>
                            
                        </div>
                    </div>

                   



                    <section id="notes" class="mt-10">
                        <div class="mx-auto">
                            
                            @if (count($notes) == 0)
                                    <h3 class="text-lg w-full">You dont have any notes yet, check you filter to see if you really have no notes.</h1>
                            @endif
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                                

                                <ul class="space-y-8">
                                    @foreach ($notes as $index => $note)
                                        @if ($index % 3 == 0)
                                            <li class="text-sm leading-6">
                                                <div class="relative space-y-6 rounded-lg bg-slate-800">
                                                    <div class="flex items-center space-x-4">
                                                        <h3
                                                            class="text-lg text-black font-semibold text-white bg-{{ $note->tagColor }}-400 w-full px-4 py-2 rounded-tr-lg rounded-tl-lg">
                                                            {{ $note->title }}</h3>
                                                    </div>
                                                    <p class="text-gray-300 text-md px-4">{{ $note->content }}</p>
                                                    <div class="flex justify-between">
                                                        <p class="text-gray-500 px-4 pb-3">Last edited on
                                                            {{ $note->updated_at->format('d-m-Y') }}</p>
                                                        <p id="editBtn" data-id="{{ $note->id }}"
                                                            data-title="{{ $note->title }}"
                                                            data-content="{{ $note->content }}"
                                                            data-color="{{ $note->tagColor }}"
                                                            class="editBtn text-gray-500 px-4 pb-3 hover:underline cursor-pointer">
                                                            Edit</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                                <ul class="space-y-8">
                                    @foreach ($notes as $index => $note)
                                        @if ($index % 3 == 1)
                                            <li class="text-sm leading-6">
                                                <div class="relative space-y-6 rounded-lg bg-slate-800">
                                                    <div class="flex items-center space-x-4">
                                                        <h3
                                                            class="text-lg text-black font-semibold text-white bg-{{ $note->tagColor }}-400 w-full px-4 py-2 rounded-tr-lg rounded-tl-lg">
                                                            {{ $note->title }}</h3>
                                                    </div>
                                                    <p class="text-gray-300 text-md px-4">{{ $note->content }}</p>
                                                    <div class="flex justify-between">
                                                        <p class="text-gray-500 px-4 pb-3">Last edited on
                                                            {{ $note->updated_at->format('d-m-Y') }}</p>
                                                        <p id="editBtn" data-id="{{ $note->id }}"
                                                            data-title="{{ $note->title }}"
                                                            data-content="{{ $note->content }}"
                                                            data-color="{{ $note->tagColor }}"
                                                            class="editBtn text-gray-500 px-4 pb-3 hover:underline cursor-pointer">
                                                            Edit</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                                <ul class="space-y-8">
                                    @foreach ($notes as $index => $note)
                                        @if ($index % 3 == 2)
                                            <li class="text-sm leading-6">
                                                <div class="relative space-y-6 rounded-lg bg-slate-800">
                                                    <div class="flex items-center space-x-4">
                                                        <h3
                                                            class="text-lg text-black font-semibold text-white bg-{{ $note->tagColor }}-400 w-full px-4 py-2 rounded-tr-lg rounded-tl-lg">
                                                            {{ $note->title }}</h3>
                                                    </div>
                                                    <p class="text-gray-300 text-md px-4">{{ $note->content }}</p>
                                                    <div class="flex justify-between">
                                                        <p class="text-gray-500 px-4 pb-3">Last edited on
                                                            {{ $note->updated_at->format('d-m-Y') }}</p>
                                                        <p id="editBtn" data-id="{{ $note->id }}"
                                                            data-title="{{ $note->title }}"
                                                            data-content="{{ $note->content }}"
                                                            data-color="{{ $note->tagColor }}"
                                                            class="editBtn text-gray-500 px-4 pb-3 hover:underline cursor-pointer">
                                                            Edit</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>


                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>
        // Ajax csrf token setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Open filter modal
        $('#filterBtn').click(function() {
            $('#colorFilterForm').removeClass('hidden');
        });

        $(document).ready(function() {
            $('.filter-button').click(function() {
                var color = $(this).data('color');

                //Close the modal
                $('#colorFilterForm').addClass('hidden');

                $.ajax({
                    url: "{{ route('notes') }}",
                    type: 'GET',
                    data: {
                        color: color
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        //Open Create Modal
        $('#create-note').click(function() {
            $('#notesModal').removeClass('hidden');

            var color = $('input[name="color-radio"]:checked').val();
            console.log(color);
            $('#color-tag').removeClass();
            $('#color-tag').addClass('w-full bg-' + color + '-400 h-10');
        });

        //Close Create Modal
        $('#closeBtnNotes').click(function() {
            $('#notesModal').addClass('hidden');
        });

        $('#radio-buttons input').on('change', function() {
            var color = $(this).val();
            $('#color-tag').removeClass();
            $('#color-tag').addClass('w-full bg-' + color + '-400 h-10');
        });

        //Set filter on change
        $('#colorFilterForm').on('change', function() {
            $('#colorFilterForm').submit();
        });

        //set radio button on load
        $(document).ready(function() {
            //get color from url
            var color = new URLSearchParams(window.location.search).get('color-filter');
            if (color == 'all') {
                $('#color-filter-all').prop('checked', true);
            } else {
                $('#color-filter-' + color).prop('checked', true);
            }
        });

        //Save Note to the database
        $('#saveBtnNotes').click(function() {

            //Get the values from the inputs
            var title = $('#title').val();
            var content = $('#note-content').val();
            var tagColor = $('#radio-buttons input:checked').val();

            // Validate the inputs
            if (title == '') {
                $('#titleError').text('Title is required');
            } else if (content == '') {
                $('#titleError').text('Content is required');
            } else {
                $('#titleError').text('');
                $('#notesModal').addClass('hidden');
            }

            // Save the note to the database
            $.ajax({
                url: "{{ route('notes.store') }}",
                type: 'POST',
                data: {
                    title: title,
                    content: content,
                    tagColor: tagColor,
                },
                success: function(response) {
                    // Close the modal, clear the inputs, etc.
                    $('#title').val('');
                    $('#note-content').val('');
                    $('#color-tag').removeClass();
                    $('#color-tag').addClass('w-full bg-fuchsia-400 h-10');

                    location.reload();
                },
                error: function(error) {
                    console.error(error);
                }
            });

        });

        //Open Edit Modal and set the values
        $('.editBtn').click(function() {
            $('#editNotesModal').removeClass('hidden'); //Open Edit Modal

            var color = $(this).val();
            $('#color-tag').removeClass();
            $('#color-tag').addClass('w-full bg-' + color + '-400 h-10');

            //Get the values from the clicked note
            var id = $(this).data('id');
            var title = $(this).data('title');
            var content = $(this).data('content');
            var color = $(this).data('color');

            // Set the values to the edit modal
            $('#editTitle').val(title);
            $('#editContent').val(content);
            $('#edit-color-tag').removeClass();
            $('#edit-color-tag').addClass('w-full bg-' + color + '-400 h-10'); //Set correct color tag

            // Set selected radio button
            $('#editRadio-buttons input').each(function() {
                if ($(this).val() == color) {
                    $(this).prop('checked', true);
                }
            });

            // Set the id to the save button
            $('#editSaveBtnNotes').data('id', id);



        });

        //Change color tag on radio button change for edit modal
        $('#editRadio-buttons input').on('change', function() {
            var color = $(this).val();
            $('#edit-color-tag').removeClass();
            $('#edit-color-tag').addClass('w-full bg-' + color + '-400 h-10');
        });

        //Close Edit Modal
        $('#editCloseBtnNotes').click(function() {
            $('#editNotesModal').addClass('hidden');
        });

        // Update the note with the new values
        $('#editSaveBtnNotes').click(function() {
            // Get the values from the inputs
            var id = $(this).data('id');
            var updatedTitle = $('#editTitle').val();
            var updatedContent = $('#editContent').val();
            var updatedColor = $('input[name="edit-color-radio"]:checked').val();

            // Update the note
            $.ajax({
                url: "{{ route('notes.update', '') }}" + '/' + id,
                type: "PATCH",
                dataType: 'json',
                data: {
                    title: updatedTitle,
                    content: updatedContent,
                    tagColor: updatedColor,
                },
                success: function(response) {
                    $('#editNotesModal').addClass('hidden');
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Delete the note
        $('#deleteEditButton').click(function() {
            var id = $('#editSaveBtnNotes').data('id');
            $.ajax({
                url: "{{ route('notes.destroy', '') }}" + '/' + id,
                type: 'DELETE',
                success: function(response) {
                    $('#editNotesModal').addClass('hidden');
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>

</body>

</html>
