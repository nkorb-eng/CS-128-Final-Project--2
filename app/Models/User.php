<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'UserID';
    public $timestamps = false;

    protected $fillable = [
        'Username',
        'Email',
        'Password',
        'Phone',
        'Country',
        'avater',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];
}