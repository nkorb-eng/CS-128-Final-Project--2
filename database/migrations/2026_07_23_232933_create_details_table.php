<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // 'room' or 'facility'
            $table->string('slug')->unique(); // e.g. 'superior-room', 'swimming-pool'
            $table->string('title');
            $table->string('image')->nullable();
            $table->longText('description')->nullable(); // Rich Text HTML content
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('details');
    }
};