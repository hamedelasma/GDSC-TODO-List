<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'code'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tasks()
    {
       return $this->hasMany(Task::class, 'team_id','id');
    }
}
