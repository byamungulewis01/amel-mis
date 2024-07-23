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
        Schema::create('cash_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('contract_id')->constrained()->onDelete('restrict');
            $table->bigInteger('request_amount');
            $table->string('request_for');
            $table->string('purchase_order_file');
            $table->string('estimated_badge_file');
            $table->enum('status', ['requested', 'approved', 'rejected'])->default('requested');
            $table->foreignUuid('stored_by')->constrained('users')->onDelete('restrict');
            $table->foreignUuid('approvedOrRejected_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->date('approveOrRejectDate')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('isMoneyRecieved')->default(false);
            $table->foreignUuid('moneySentby')->nullable()->constrained('users')->onDelete('restrict');
            $table->date('moneyRecievedDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_requests');
    }
};
