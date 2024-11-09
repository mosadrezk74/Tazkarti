<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function createEvent(Request $request)
    {
        $validated = $request->validate([
            'f_team' => ['required', 'integer'],
            's_team' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'status' => ['required', 'integer', 'in:0,1'],
            'stadium_id' => ['required', 'integer', 'exists:stadiums,id'],
            'price' => ['required', 'integer'],
            'numbers' => ['required', 'integer'],
            'time' => ['required', 'integer'],
        ]);

        $event = Event::create([
            'f_team' => $validated['f_team'],
            's_team' => $validated['s_team'],
            'date' => $validated['date'],
            'status' => $validated['status'],
            'stadium_id' => $validated['stadium_id'],
            'price' => $validated['price'],
            'numbers' => $validated['numbers'],
            'time' => $validated['time'],
        ]);

        return response()->json(['event' => $event]);
    }

    public function getEvent(){
        $event = Event::with('firstTeamClub', 'secondTeamClub','staduim')->get();
        $events = $event->map(function ($event) {
            return [
                'id' => $event->id,
                'f_team' => $event->firstTeamClub->name_ar,
                's_team' => $event->secondTeamClub->name_ar,
                'date' => $event->date,
                'status' => $event->status,
                'staduim' => $event->staduim->name_ar,
                'price' => $event->price,
                'numbers' => $event->numbers,

            ];
        });
        return response()->json(['event' => $events]);
    }


}
