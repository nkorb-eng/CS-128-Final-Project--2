<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Allow bcrypt and Argon password hashes for existing and new accounts. */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('Password', 255)->change();
        });

        Schema::table('emp_login', function (Blueprint $table) {
            $table->string('Emp_Password', 255)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('Password', 50)->change();
        });

        Schema::table('emp_login', function (Blueprint $table) {
            $table->string('Emp_Password', 50)->change();
        });
    }
};
