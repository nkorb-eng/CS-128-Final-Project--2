<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    public $incrementing = false; 
    public $timestamps = false;

    protected $fillable = [
        'id', 'Name', 'Email', 'RoomType', 'Bed', 'NoofRoom', 'cin', 'cout',
        'noofdays', 'roomtotal', 'bedtotal', 'meal', 'mealtotal', 'finaltotal',
    ];

    /**
     * Centralized Booking Pricing Calculator
     */
    public static function calculate(string $roomType, string $bed, string $meal, int $noofday, int $noofRoom = 1): array
    {
        $roomAndBedRate = Room::calculatePrice($roomType, $bed);

        $mealRate = match ($meal) {
            'Breakfast'  => 5.00,
            'Half Board' => 10.00,
            'Full Board' => 15.00,
            default      => 0.00,
        };

        $roomtotal  = $roomAndBedRate * $noofday;
        $bedtotal   = 0; 
        $mealtotal  = $mealRate * $noofday;
        $finaltotal = $roomtotal + $mealtotal;

        return [$roomtotal, $bedtotal, $mealtotal, $finaltotal];
    }
}