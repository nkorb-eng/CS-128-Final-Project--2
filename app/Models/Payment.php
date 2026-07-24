<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    
    public $timestamps = false;

    protected $fillable = [
        'id', 'Name', 'Email', 'RoomType', 'Bed', 'NoofRoom', 'cin', 'cout',
        'noofdays', 'roomtotal', 'bedtotal', 'meal', 'mealtotal', 'finaltotal',
        'discount', 'amount_paid', 'method', 'status', 'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /** Service tax rate applied to every bill */
    public const TAX_RATE = 0.10;

    /** Subtotal = room + bed + meal */
    public function getSubtotalAttribute(): float
    {
        return round((float) $this->finaltotal, 2);
    }

    /** Service tax charged on the subtotal */
    public function getTaxAmountAttribute(): float
    {
        return round($this->subtotal * self::TAX_RATE, 2);
    }

    /** Grand total: subtotal + tax − discount */
    public function getGrandTotalAttribute(): float
    {
        return round($this->subtotal + $this->tax_amount - (float) $this->discount, 2);
    }

    /** Outstanding balance (0 once fully paid) */
    public function getBalanceAttribute(): float
    {
        return round($this->grand_total - (float) $this->amount_paid, 2);
    }

    /** Bootstrap colour for the payment status badge */
    public function getStatusColorAttribute(): string
    {
        return match (strtolower(trim($this->status ?? ''))) {
            'paid'    => 'success',
            'partial' => 'warning',
            default   => 'danger',
        };
    }

    /** Centralized Booking Pricing Calculator */
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