<?php

namespace App\Models;

use App\Models\Staduim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function confirmedBooking()
    {
        return $this->hasOne(ConfirmedBooking::class);
    }

    use HasFactory;
}
