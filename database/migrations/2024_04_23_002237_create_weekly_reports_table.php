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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('week_number');
            $table->date('date_from');
            $table->date('date_to');
            $table->string('tender')->nullable();
            $table->bigInteger('used_money')->default(0);
            $table->bigInteger('transport')->default(0);
            $table->bigInteger('accommodation')->default(0);
            $table->enum('status',['sent','rejected','approved'])->default('sent');
            $table->foreignUuid('stored_by')->constrained('users')->onDelete('restrict');
            $table->foreignUuid('approvedOrRejected_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->date('approveOrRejectDate')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
