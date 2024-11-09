<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ConfirmedBooking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function makeBook(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        $event = Event::find($validatedData['event_id']);

        if ($event->numbers <= 0) {
            return response()->json(['message' => 'No available spots for this event.'], 400);
        }

        $eventItem = Book::where('user_id', $user->id)
            ->where('event_id', $validatedData['event_id'])
            ->first();

        if ($eventItem) {
            return response()->json(['message' => 'You have already booked this event.']);
        } else {

            $eventResult = Book::create([
                'user_id' => $user->id,
                'event_id' => $validatedData['event_id'],
            ]);

            $event->decrement('numbers');

            return response()->json([
                'event' => $eventResult,
                'message' => 'Event added to booking successfully.']);
        }
    }

    public function getBook()
    {
        $user = auth()->user();
        $book = Book::where('user_id', $user->id)->with('event')->get();
        $events = $book->map(function ($book) {
            return [
                'id' => $book->id,
                'event_id' => $book->event_id,
                'f_team' => $book->event->firstTeamClub->name_ar,
                's_team' => $book->event->secondTeamClub->name_ar,
                'date' => $book->event->date,
                'status' => $book->event->status,
                'staduim' => $book->event->staduim->name_ar,
                'price' => $book->event->price,
                'numbers' => $book->event->numbers,
            ];
        });
        return response()->json(['eventsDetails' => $events]);
    }
    public function confirmBooking(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:books,id',
            'payment_status' => 'required|integer',
            'amount_paid' => 'required|numeric',
        ]);

        $booking = Book::find($validated['booking_id']);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found.'], 404);
        }

        $confirmedBooking = ConfirmedBooking::create([
            'booking_id' => $booking->id,
            'payment_status' => $validated['payment_status'],
            'amount_paid' => $validated['amount_paid'],
        ]);

        return response()->json(['confirmed_booking' => $confirmedBooking], 201);
    }



}
