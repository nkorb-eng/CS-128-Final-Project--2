<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    public $incrementing = false; // id mirrors the roombook id, not auto-generated
    public $timestamps = false;

    protected $fillable = [
        'id', 'Name', 'Email', 'RoomType', 'Bed', 'NoofRoom', 'cin', 'cout',
        'noofdays', 'roomtotal', 'bedtotal', 'meal', 'mealtotal', 'finaltotal',
    ];

    /**
     * Reproduce the exact billing maths from the original PHP
     * (roomconfirm.php / roombookedit.php).
     *
     * Returns [roomtotal, bedtotal, mealtotal, finaltotal].
     */
    public static function calculate(string $roomType, string $bed, string $meal, int $noofday, int $noofRoom): array
    {
        $roomRate = match ($roomType) {
            'Superior Room' => 3000,
            'Deluxe Room'   => 2000,
            'Guest House'   => 1500,
            'Single Room'   => 1000,
            default         => 0,
        };

        $bedRate = match ($bed) {
            'Single' => $roomRate * 1 / 100,
            'Double' => $roomRate * 2 / 100,
            'Triple' => $roomRate * 3 / 100,
            'Quad'   => $roomRate * 4 / 100,
            default  => 0, // None
        };

        $mealRate = match ($meal) {
            'Breakfast'  => $bedRate * 2,
            'Half Board' => $bedRate * 3,
            'Full Board' => $bedRate * 4,
            default      => 0, // Room only
        };

        $roomtotal = $roomRate * $noofday * $noofRoom;
        $bedtotal  = $bedRate * $noofday;
        $mealtotal = $mealRate * $noofday;
        $finaltotal = $roomtotal + $mealtotal + $bedtotal;

        return [$roomtotal, $bedtotal, $mealtotal, $finaltotal];
    }
}
