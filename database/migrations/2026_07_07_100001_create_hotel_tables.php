<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Admin / employee logins
        Schema::create('emp_login', function (Blueprint $table) {
            $table->increments('empid');
            $table->string('Emp_Email', 50);
            $table->string('Emp_Password', 255);
        });

        // Room inventory
        Schema::create('room', function (Blueprint $table) {
            $table->increments('id');
            $table->string('room_no', 20)->unique();
            $table->string('type', 50);
            $table->string('bedding', 50);
            $table->decimal('price', 10, 2);
        });

        // Reservations
        Schema::create('roombook', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name', 50);
            $table->string('Email', 50);
            $table->string('Country', 30);
            $table->string('Phone', 30);
            $table->string('RoomType', 30);
            $table->string('Bed', 30);
            $table->string('Meal', 30);
            $table->string('NoofRoom', 30);
            $table->date('cin');
            $table->date('cout');
            $table->integer('nodays');
            $table->string('stat', 30);
        });

        // Payments / POS Invoices
        Schema::create('payment', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('Name', 30);
            $table->string('Email', 30);
            $table->string('RoomType', 30);
            $table->string('Bed', 30);
            $table->integer('NoofRoom');
            $table->date('cin');
            $table->date('cout');
            $table->integer('noofdays');
            $table->double('roomtotal', 8, 2);
            $table->double('bedtotal', 8, 2);
            $table->string('meal', 30);
            $table->double('mealtotal', 8, 2);
            $table->double('finaltotal', 8, 2);
            
            // Integrated POS Fields
            $table->double('discount', 8, 2)->default(0);
            $table->double('amount_paid', 8, 2)->default(0);
            $table->string('method', 20)->nullable();
            $table->string('status', 20)->default('Unpaid');
            $table->dateTime('paid_at')->nullable();
        });

        // Hotel staff
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->string('work', 30);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
        Schema::dropIfExists('payment');
        Schema::dropIfExists('roombook');
        Schema::dropIfExists('room');
        Schema::dropIfExists('emp_login');
    }
};