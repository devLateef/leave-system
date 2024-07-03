<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('staff_id');
            $table->string('department');
            $table->string('email')->unique();
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->string('phone');
            $table->string('city');
            $table->string('country');
            $table->string('address');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(Hash::make(config('admin.DEFAULT')));
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
