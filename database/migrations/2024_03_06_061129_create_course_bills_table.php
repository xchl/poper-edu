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
        Schema::create('course_bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id')->unique();
            $table->uuid('teacher_user_id')->index();
            $table->string('name');
            $table->tinyInteger('bill_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_bills');
    }
};
