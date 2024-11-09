<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staduim extends Model
{
    protected $table = 'stadiums';

    protected $fillable = [
        'name_ar',
        'name_en',
        'capacity',
        'city',

        'number_of_seats',

    ];
    public function event(){
        return $this->hasMany(Event::class);
    }

    use HasFactory;
}
