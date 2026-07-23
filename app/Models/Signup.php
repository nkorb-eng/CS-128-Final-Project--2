<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    protected $table = 'signup';
    protected $primaryKey = 'UserID';
    public $timestamps = false;

    protected $fillable = ['Username', 'Email', 'Password'];
}
