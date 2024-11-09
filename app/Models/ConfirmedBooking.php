<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmedBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'booking_id', 'payment_status', 'amount'];

    public function booking()
    {
        return $this->belongsTo(Book::class);
    }
}
