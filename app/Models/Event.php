<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'f_team',
        's_team',
        'date',
        'status',
        'time',
        'stadium_id',
        'price',
        'numbers',


    ];
    public function firstTeamClub()
    {
        return $this->belongsTo(Club::class, 'f_team', 'id');
    }

    public function secondTeamClub()
    {
        return $this->belongsTo(Club::class, 's_team', 'id');
    }

// Custom method to return either relationship
    public function club()
    {
        return $this->firstTeamClub ?? $this->secondTeamClub;
    }

    public function staduim(){
        return $this->belongsTo(Staduim::class, 'stadium_id', 'id');
    }
    use HasFactory;
}
