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
        Schema::create('semesters', function (Blueprint $table) {
            $table->id('semester_id');
            $table->string('semester_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('earliest_check_in_date');
            $table->date('latest_check_out_date');
            $table->decimal('price', 8, 2);
            $table->date('new_reg_open_date');
            $table->date('new_reg_close_date');
            $table->date('extension_reg_open_date');
            $table->date('extension_reg_close_date');
            //$table->integer('status'); //1-open 0-close
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stay_applications');
    }
};
