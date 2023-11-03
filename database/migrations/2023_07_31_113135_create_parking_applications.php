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
        Schema::create('parking_applications', function (Blueprint $table) {
            $table->id('parking_application_id');
            $table->integer('student_id');
            $table->string('make');
            $table->string('model');
            $table->string('year');
            $table->string('color');
            $table->string('plate_no');
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
        Schema::dropIfExists('parking_applications');
    }
};
