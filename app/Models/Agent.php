<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'email', 'pan_card', 'password'
    ];

    protected $hidden = [
        'password'
    ];
}
