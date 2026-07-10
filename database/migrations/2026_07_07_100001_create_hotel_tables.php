<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ported from the original "bluebirdhotel" MySQL dump.
 * Table and column names are kept identical to the source project so the
 * behaviour matches the original Hotel Management System one-to-one.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Admin / employee logins
        Schema::create('emp_login', function (Blueprint $table) {
            $table->increments('empid');
            $table->string('Emp_Email', 50);
            $table->string('Emp_Password', 50);
        });

        // Registered site users
        Schema::create('signup', function (Blueprint $table) {
            $table->increments('UserID');
            $table->string('Username', 50);
            $table->string('Email', 50);
            $table->string('Password', 50);
        });

        // Room inventory
        Schema::create('room', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 50);
            $table->string('bedding', 50);
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

        // Payments / invoices
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
        Schema::dropIfExists('signup');
        Schema::dropIfExists('emp_login');
    }
};
