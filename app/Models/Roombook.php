<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roombook extends Model
{
    protected $table = 'roombook';
    public $timestamps = false;

    protected $fillable = [
        'Name', 'Email', 'Country', 'Phone', 'RoomType', 'Bed',
        'Meal', 'NoofRoom', 'cin', 'cout', 'nodays', 'stat',
    ];
}
