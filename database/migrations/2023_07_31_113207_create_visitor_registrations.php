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
        Schema::create('visitor_registrations', function (Blueprint $table) {
            $table->id('visitor_reg_id');
            $table->integer('student_id');
            $table->string('visitor_name');
            $table->text('visit_purpose');
            $table->date('visit_date');
            $table->time('visit_time');
            $table->integer('duration');
            $table->string('qr_code')->nullable();
            $table->string('status');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_registrations');
    }
};
