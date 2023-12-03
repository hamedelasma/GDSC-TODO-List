<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

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

}
