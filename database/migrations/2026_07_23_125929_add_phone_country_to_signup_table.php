<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('signup', function (Blueprint $table) {
            $table->string('Phone', 30)->nullable()->after('Email');
            $table->string('Country', 100)->nullable()->after('Phone');
        });
    }

    public function down(): void
    {
        Schema::table('signup', function (Blueprint $table) {
            $table->dropColumn(['Phone', 'Country']);
        });
    }
};