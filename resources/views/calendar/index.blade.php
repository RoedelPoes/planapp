<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>
    @vite('resources/css/app.css')

    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <!-- CDN's for fullCalendar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <!-- FullCalendar styling -->
    <style>
        .fc-title,
        .fc-day-number,
        .fc-event-title,
        .fc-event-time,
        .fc-day-header {
            color: white !important;
        }

        .fc-today {
            background-color: #f472b569 !important;
        }

        .fc-state-default {
            background-color: transparent !important;
            border-color: white !important;
            background-image: none !important;
            text-shadow: none !important;
            color: white;
        }

        .fc-state-active {
            background-color: #f472b5 !important;
            border-color: #f472b5 !important;
        }

        .fc-state-hover {
            transition: none !important;
        }

        .fc-now-indicator.fc-now-indicator-arrow::before {
            background-color: #f472b5;
            content: "";
            display: block;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            margin-top: -7px;
        }

        .fc-now-indicator.fc-now-indicator-arrow {
            left: 44px !important;
            right: 0;
            background-color: #f472b5;
            height: 2px;
            margin: 0;
            border: none;
            z-index: 999;
        }

        .fc-axis>span {
            color: white;
        }


        /* Input icons styling */
        input[type="time"]::-webkit-calendar-picker-indicator,
        input[type="datetime-local"]::-webkit-calendar-picker-indicator{
            filter: invert(100%) grayscale(100%);
        }
    </style>
</head>


<x-app-layout>
    <!-- Insert Modal -->
    <div id="bookingModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-75">
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-gray-700 px-4 py-4">
                <label for="title" class="text-white m-2 mt-2 block">Title</label>
                <span id="titleError" class="text-red-500 w-full block"></span>
                <input type="text"
                    class="w-full px-3 py-2 mb-3 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                    id="title" placeholder="Event Title">

                <div class="flex items-top mx-2 py-2">
                    <input type="checkbox" id="all_day"
                        class="text-pink-400 focus:ring-pink-400 h-4 w-4 border-gray-300 rounded">
                    <label for="all_day" class="ml-2 block text-sm text-white">All Day Event</label>
                </div>

                <div class="flex justify-between">
                    <div class="w-full mr-2">
                        <label for="start_time" class="text-white m-2 block">Starting Time</label>
                        <input type="time"
                            class="w-full px-3 py-2 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                            id="start_time" placeholder="Start Time">
                    </div>
                    <div class="w-full ml-2">
                        <label for="end_time" class="text-white m-2 block">Ending Time</label>
                        <input type="time"
                            class="w-full px-3 py-2 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                            id="end_time" placeholder="End Time">
                    </div>
                </div>
            </div>
            <div class="bg-gray-700 px-4 py-3 pb-6 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="saveBtn"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400 sm:ml-3 sm:w-auto sm:text-sm">
                    Save changes
                </button>
                <button type="button" id="closeBtn"
                    class="w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
    <!-- Inert Modal end -->


    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-75">
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-gray-700 px-4 py-4">
                <label for="editTitle" class="text-white m-2 mt-4 block">Edit Title</label>
                <span id="editTitleError" class="text-red-500 w-full block"></span>
                <input type="text"
                    class="w-full px-3 py-2 mb-3 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                    id="editTitle" placeholder="Event Title">

                <div class="flex justify-between">
                    <div class="w-full mr-2">
                        <label for="editStartTime" class="text-white m-2 block">Starting Time</label>
                        <input type="datetime-local"
                            class="w-full px-3 py-2 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                            id="editStartTime" placeholder="Start Time">
                    </div>
                    <div class="w-full ml-2">
                        <label for="editEndTime" class="text-white m-2 block">Ending Time</label>
                        <input type="datetime-local"
                            class="w-full px-3 py-2 bg-gray-900 text-gray-300 border border-gray-600 rounded-md focus:outline-none focus:ring-pink-400 focus:border-pink-400 sm:text-sm"
                            id="editEndTime" placeholder="End Time">
                    </div>
                </div>
            </div>
            <div class="bg-gray-700 px-4 py-3 pb-6 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="saveEditBtn"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400 sm:ml-3 sm:w-auto sm:text-sm">
                    Save changes
                </button>
                <button type="button" id="deleteEditButton"
                    class="w-full inline-flex justify-center rounded-md border border-red-600 shadow-sm px-4 py-2 bg-red-700 text-base font-medium text-gray-300 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
                <button type="button" id="closeEditBtn"
                    class="w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
    <!-- Edit Modal end -->

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <div id='calendar' class="text-white">
                    <!-- Calendar will be displayed here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show booking modal
        function showBookingModal() {
            $('#bookingModal').removeClass('hidden');
        }

        // Function to validate time range
        function validateTimeRange() {
            var startTime = $('#start_time').val();
            var endTime = $('#end_time').val();

            if (startTime && endTime) {
                var startDate = new Date('2000-01-01T' + startTime + ':00');
                var endDate = new Date('2000-01-01T' + endTime + ':00');

                if (startDate >= endDate) {
                    $('#titleError').text('End time must be later than start time');
                    return false;
                } else {
                    $('#titleError').text('');
                    return true;
                }
            }

            return true;
        }

        // Close booking modal
        function closeBookingModal() {
            $('#bookingModal').addClass('hidden');
            $('#saveBtn').off('click');
            $('#titleError').text('');
            $('#all_day').prop('checked', false);
            $('#start_time, #end_time').prop('disabled', false);
        }

        $(document).ready(function() {

            // Set CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //When the checkbox is checked, the start_time and end_time inputs are disabled and cleared.
            $('#all_day').change(function() {
                if ($(this).prop('checked')) {
                    $('#start_time').val('');
                    $('#end_time').val('');
                }
            });

            // Get events from controller
            var booking = @json($events);

            // Initialize fullCalendar
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev, next today',
                    center: 'title',
                    right: 'month, agendaWeek, agendaDay',
                }, // Header buttons
                events: booking, // Load events
                selectable: true, // Allow selection
                selectHelper: true, // Show selection helper
                nowindicator: true, // Show current time indicator
                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                }, // Button text
                nowIndicator: true, // Show current time indicator
                allDaySlot: false, // Hide all-day slot
                timeFormat: 'H:mm', // Time format
                eventColor: '#f472b5', // Event color
                slotEventOverlap: false, // Prevent overlapping events, put them side by side
                // Add event
                select: function(start, end, allDays) {

                    var selectedTime = moment(start).format(
                        'HH:mm'); // Convert start time to desired format

                    //Only fills input when the selected time is not 00:00
                    if (selectedTime != '00:00') {
                        $('#start_time').val(
                            selectedTime); // Populate start_time input with selected time
                    }

                    // Open booking modal
                    $('#bookingModal').removeClass('hidden');

                    // Close booking modal
                    $('#bookingModal').on('click', '#closeBtn', function() {
                        closeBookingModal();
                    });

                    $('#saveBtn').on('click', function() {
                        var title = $('#title').val();
                        var start_time = $('#start_time').val();
                        var end_time = $('#end_time').val();
                        var date = moment(start).format('YYYY-MM-DD');

                        // Determine if it's an all-day event
                        var isAllDay = $('#all_day').prop('checked');
                        var start_datetime, end_datetime;

                        // Set start and end times
                        if (isAllDay) {
                            // For all-day events, set start and end times to whole day
                            console.log('All day event');
                            start_datetime = moment(start).startOf('day').format(
                                'YYYY-MM-DD HH:mm:ss');
                            end_datetime = moment(start).endOf('day').format(
                                'YYYY-MM-DD HH:mm:ss');
                        } else {
                            // Combine date and time into datetime strings
                            start_datetime = moment(date + ' ' + start_time, 'YYYY-MM-DD HH:mm')
                                .format('YYYY-MM-DD HH:mm:ss');
                            end_datetime = moment(date + ' ' + end_time, 'YYYY-MM-DD HH:mm')
                                .format('YYYY-MM-DD HH:mm:ss');
                        }

                        // Validate time range if it's not an all-day event
                        if (!isAllDay && moment(start_datetime).isSameOrAfter(end_datetime)) {
                            $('#titleError').text('End time must be later than start time');
                            return;
                        }

                        // Save event
                        $.ajax({
                            url: "{{ route('calendar.store') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {
                                title: title,
                                start_date: start_datetime,
                                end_date: end_datetime
                            },
                            // If successful, close modal and reload page
                            success: function(response) {
                                closeBookingModal();
                                location.reload();
                            },
                            // If error, display error message
                            error: function(error) {
                                if (error.responseJSON.errors) {
                                    $('#titleError').html(error.responseJSON.errors
                                        .title);
                                }
                            },
                        });
                    });
                },
                editable: true, // Allow drag and drop
                // Drag and drop event
                eventDrop: function(event) {
                    var id = event.id;
                    var start_date = moment(event.start).format('YYYY-MM-DD HH:mm');
                    var end_date = moment(event.end).format('YYYY-MM-DD HH:mm');

                    // Update event
                    $.ajax({
                        url: "{{ route('calendar.update', '') }}" + '/' + id,
                        type: "PATCH",
                        dataType: 'json',
                        data: {
                            start_date,
                            end_date
                        },
                        // If successful, do nothing
                        success: function(response) {
                            //
                        },
                        // If error, display error message
                        error: function(error) {
                            console.log(error)
                        },
                    });
                },
                // Edit event
                eventClick: function(event) {
                    var id = event.id;
                    var title = event.title;
                    var start_date = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    var end_date = moment(event.end).format('YYYY-MM-DD HH:mm:ss');

                    // Show the edit modal
                    $('#editModal').removeClass('hidden');

                    // Populate modal fields with event data
                    $('#editTitle').val(title);
                    $('#editAllDay').prop('checked', event.allDay);
                    $('#editStartTime').val(start_date);
                    $('#editEndTime').val(end_date);

                    // Handle Save button click
                    $('#saveEditBtn').off('click').on('click', function() {
                        var updatedTitle = $('#editTitle').val();
                        var updatedStartTime = $('#editStartTime').val().replace('T', ' ') +
                            ':00';
                        var updatedEndTime = $('#editEndTime').val().replace('T', ' ') + ':00';

                        // Update event via AJAX
                        $.ajax({
                            url: "{{ route('calendar.update', '') }}" + '/' + id,
                            type: "PATCH",
                            dataType: 'json',
                            data: {
                                title: updatedTitle,
                                start_date: updatedStartTime,
                                end_date: updatedEndTime,
                            },
                            success: function(response) {
                                closeEditModal();
                                location.reload();
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    });

                    // Handle Close button click
                    $('#closeEditBtn').off('click').on('click', function() {
                        $('#editModal').addClass('hidden');
                    });

                    $('#deleteEditButton').off('click').on('click', function() {
                        if (confirm('Are you sure want to remove it')) {
                            // Delete event
                            $.ajax({
                                url: "{{ route('calendar.destroy', '') }}" + '/' + id,
                                type: "DELETE",
                                dataType: 'json',
                                // If successful, remove event from calendar
                                success: function(response) {
                                    $('#calendar').fullCalendar('removeEvents',
                                        response);
                                    location.reload();
                                },
                                // If error, display error message
                                error: function(error) {
                                    console.log(error)
                                },
                            });
                        }
                    });
                },
                // Resize event
                eventResize: function(event) {
                    var id = event.id;
                    var start_date = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    var end_date = moment(event.end).format('YYYY-MM-DD HH:mm:ss');

                    // Update event
                    $.ajax({
                        url: "{{ route('calendar.update', '') }}" + '/' + id,
                        type: "PATCH",
                        dataType: 'json',
                        data: {
                            start_date,
                            end_date
                        },
                        // If successful, do nothing
                        success: function(response) {
                            //
                        },
                        // If error, display error message
                        error: function(error) {
                            console.log(error)
                        },
                    });
                },


                // Prevent selection of multiple days
                selectAllow: function(event) {
                    return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1,
                        'second').utcOffset(false), 'day');
                },

            });

            // Handle checkbox change for all-day events
            function closeBookingModal() {
                $('#bookingModal').addClass('hidden');
                $('#saveBtn').off('click');
            }

            function closeEditModal() {
                $('#editModal').addClass('hidden');
                $('#saveEditBtn').off('click');
            }

            // Handle checkbox change for all-day events
            $('#all_day').on('change', function() {
                var isChecked = $(this).prop('checked');

                if (isChecked) {
                    $('#start_time, #end_time').prop('disabled', true);
                } else {
                    $('#start_time, #end_time').prop('disabled', false);
                }
            });
        });
    </script>
</x-app-layout>

</body>

</html>
