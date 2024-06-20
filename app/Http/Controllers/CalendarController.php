<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = array();
        $bookings = Booking::where('user_id', Auth::id())->get();
        foreach ($bookings as $booking) {
            $events[] = [
                'id'   => $booking->id,
                'title' => $booking->title,
                'start' => $booking->start_date,
                'end' => $booking->end_date,
            ];
        }
        return view('calendar.index', ['events' => $events]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $booking = Booking::create([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'id' => $booking->id,
            'start' => $booking->start_date,
            'end' => $booking->end_date,
            'title' => $booking->title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Find the booking record for the authenticated user
        $booking = Booking::where('user_id', Auth::id())->find($id);

        if (!$booking) {
            return response()->json([
                'error' => 'Booking not found or you do not have permission to update it'
            ], 404);
        }

        // Validate the request data for the specific scenario
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255', // 'sometimes' allows for partial updates
            'start_date' => 'required|date_format:Y-m-d H:i:s', // Requires full update of start_date
            'end_date' => 'required|date_format:Y-m-d H:i:s', // Requires full update of end_date
        ]);

        // Prepare data for update
        $updateData = [
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ];

        // Only update title if provided
        if (isset($validatedData['title'])) {
            $updateData['title'] = $validatedData['title'];
        }

        // Update the booking record
        $booking->update($updateData);

        return response()->json([
            'id' => $booking->id,
            'title' => $booking->title,
            'start' => $booking->start_date,
            'end' => $booking->end_date,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())->find($id);
        if (!$booking) {
            return response()->json([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $booking->delete();
        return response()->json('Event deleted');
    }
}
