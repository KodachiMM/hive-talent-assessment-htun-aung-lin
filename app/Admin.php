<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'full_name', 'email', 'password', 'last_login',
    ];

    protected $dates = [
        'last_login',
    ];

    protected $hidden = [
        'password',
    ];
}
