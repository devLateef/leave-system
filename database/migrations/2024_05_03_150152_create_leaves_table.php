<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('leave_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('designation');
            $table->integer('total_days_requested')->nullable();
            $table->string('hod_approval')->default('Pending');
            $table->string('final_approval')->default('Pending');
            $table->string('standin_staff')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
