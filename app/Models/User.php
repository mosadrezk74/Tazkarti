<?php
namespace App\Models;

use App\Models\Country;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use Notifiable;
    protected $fillable = [
        'f_name',
    'l_name' , 'email',
    'password',
    'image',
    'nation_id',
    'dob',
    'nationality',
    'language',
    'status',
    'gender',

];
    protected $hidden = ['password', 'remember_token'];


    // JWT implementation methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'nation_id');
    }
}
