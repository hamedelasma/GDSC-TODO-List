<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name',
        'password',
        'phone',
        'is_team_leader',
        'status',
        'team_id'
    ];

    protected $casts =[
        'password' => 'hashed'
    ];

    protected $hidden =[
        'password'
    ];


    public function team()
    {
        return $this->belongsTo(Team::class ,'team_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
