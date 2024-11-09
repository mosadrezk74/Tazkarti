<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\ConfirmedBooking;
use App\Models\Event;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {

        $validated = $request->validate([
            'booking_id' => 'required|exists:books,id',
            'stripeToken' => 'required|string',
            'payment_status' => 'required|integer',
        ]);


        $booking = Book::find($validated['booking_id']);
        $event = Event::find($booking->event_id);


        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found.'
            ], 404);
        }

        try {

            Stripe::setApiKey(env('STRIPE_SECRET'));
            $charge = Charge::create([
                'amount' => $event->price * 100,
                'currency' => 'egp',
                'source' => $validated['stripeToken'],
                'description' => 'Book Payment for Event ID: ' . $event->id,
            ]);


            $confirmedBooking = ConfirmedBooking::create([
                'user_id' => auth()->id(),
                'booking_id' => $booking->id,
                'payment_status' => $validated['payment_status'],
                'amount' => $event->price,
            ]);

              $eventDetails = [
                'id' => $confirmedBooking->id,
                'f_team' => $event->firstTeamClub->name_ar,
                's_team' => $event->secondTeamClub->name_ar,
                'date' => $event->date,
                'status' => $event->status,
                'stadium' => $event->staduim->name_ar,
                'price' => $event->price,
                'numbers' => $event->numbers,
            ];

             return response()->json([
                'success' => true,
                'message' => 'Payment successful',
                'event' => $confirmedBooking,
                'confirmed_booking' => $eventDetails,

            ]);

        } catch (\Exception $e) {
             return response()->json([
                'success' => false,
                'message' => 'Payment failed: ' . $e->getMessage(),
            ], 500);
        }
    }

}
