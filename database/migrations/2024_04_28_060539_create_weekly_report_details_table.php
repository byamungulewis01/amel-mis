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
        Schema::create('weekly_report_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('weekly_report_id')->constrained('weekly_reports')->onDelete('cascade');
            $table->date('date');
            $table->string('activities');
            $table->string('comment')->nullable();
            $table->integer('hours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_report_details');
    }
};
