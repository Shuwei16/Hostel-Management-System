<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id('registration_id');
            $table->integer('student_id');
            $table->integer('semester_id');
            $table->integer('room_id')->nullable();
            $table->string('registration_type');
            $table->date('payment_due_date')->nullable();
            $table->date('withdrawal_due_date')->nullable();
            $table->timestamp('check_in_date')->nullable();
            $table->timestamp('check_out_date')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
