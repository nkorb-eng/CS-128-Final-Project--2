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
        'discount', 'amount_paid', 'method', 'status', 'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /** Service tax rate applied to every bill (10%). */
    public const TAX_RATE = 0.10;

    /** Subtotal = room + bed + meal (the original computed bill). */
    public function getSubtotalAttribute(): float
    {
        return round((float) $this->finaltotal, 2);
    }

    /** Service tax charged on the subtotal. */
    public function getTaxAmountAttribute(): float
    {
        return round($this->subtotal * self::TAX_RATE, 2);
    }

    /** Grand total the guest owes: subtotal + tax − discount. */
    public function getGrandTotalAttribute(): float
    {
        return round($this->subtotal + $this->tax_amount - (float) $this->discount, 2);
    }

    /** Outstanding balance (0 once fully paid). */
    public function getBalanceAttribute(): float
    {
        return round($this->grand_total - (float) $this->amount_paid, 2);
    }

    /** Bootstrap colour for the payment status badge. */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Paid'    => 'success',
            'Partial' => 'warning',
            default   => 'danger',
        };
    }

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
