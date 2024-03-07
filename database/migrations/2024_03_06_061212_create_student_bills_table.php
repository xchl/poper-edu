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
        Schema::create('student_bills', function (Blueprint $table) {
            $table->id();
            $table->uuid('student_user_id')->index();
            $table->bigInteger('course_bill_id');
            $table->bigInteger('course_id');
            $table->decimal('course_fee',8,2,true);
            $table->string('omise_charge_id');
            $table->bigInteger('bill_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_bills');
    }
};
