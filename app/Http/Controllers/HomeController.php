<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        # code...
        $events=Event::with('firstTeamClub', 'secondTeamClub','staduim')->get();
        return view('welcome',compact('events'));
    }
}
