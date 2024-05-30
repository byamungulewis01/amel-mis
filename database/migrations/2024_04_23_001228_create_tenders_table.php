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
        Schema::create('tenders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tender_name');
            $table->bigInteger('request_amount');
            $table->bigInteger('sold_amount')->nullable();
            $table->bigInteger('sales_amount')->nullable();
            $table->string('request_for');
            $table->string('purchase_order_file');
            $table->string('estimated_badge_file');
            $table->enum('status',['pending','in_progress','complete'])->default('pending');
            $table->string('description')->nullable();
            $table->foreignUuid('stored_by')->constrained('users')->onDelete('restrict');
            $table->foreignUuid('approved_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->foreignUuid('closed_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
