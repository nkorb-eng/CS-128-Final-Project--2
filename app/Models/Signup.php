<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    protected $table = 'signup';
    protected $primaryKey = 'UserID';
    public $timestamps = false;

<<<<<<< HEAD
    protected $fillable = ['Username', 'Email', 'Password', 'google_id', 'avatar'];
=======
    protected $fillable = ['Username', 'Email', 'Password'];
>>>>>>> c0e3a935b43eba1b3dc9f1bdad6c523fe64f921a
}
