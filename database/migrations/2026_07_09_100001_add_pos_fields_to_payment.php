<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds real point-of-sale fields to the payment table so a bill can
 * actually be settled: a discount, the amount collected, the method,
 * a status and the time it was paid.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->double('discount', 8, 2)->default(0)->after('finaltotal');
            $table->double('amount_paid', 8, 2)->default(0)->after('discount');
            $table->string('method', 20)->nullable()->after('amount_paid');
            $table->string('status', 20)->default('Unpaid')->after('method');
            $table->dateTime('paid_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropColumn(['discount', 'amount_paid', 'method', 'status', 'paid_at']);
        });
    }
};
