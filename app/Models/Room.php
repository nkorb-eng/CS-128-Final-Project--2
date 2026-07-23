<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';
    public $timestamps = false;
    protected $fillable = ['room_no', 'type', 'bedding', 'price','image'];

    public static function calculatePrice(string $type, string $bedding): float
    {
        // Base price for the room type
        $basePrice = match ($type) {
            'Single Room'   => 10.00,
            'Guest House'   => 12.00,
            'Deluxe Room'   => 22.00,
            'Superior Room' => 35.00,
            default         => 10.00,
        };

        // Additional cost for extra beds
        $bedAdder = match ($bedding) {
            'Single' => 0.00,
            'Double' => 5.00,
            'Triple' => 10.00,
            'Quad'   => 15.00,
            default  => 0.00,
        };

        return $basePrice + $bedAdder;
    }
}
