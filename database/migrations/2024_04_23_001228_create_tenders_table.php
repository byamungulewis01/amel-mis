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
            $table->bigInteger('bid_security');
            $table->bigInteger('tender_fees');
            $table->text('description');
            $table->date('opening_date');
            $table->date('submitted_date');
            $table->json('documents')->nullable();
            $table->enum('status',['new','won','lost'])->default('new');
            $table->bigInteger('sales_amount')->nullable();
            $table->text('explainations')->nullable();
            $table->foreignUuid('stored_by')->constrained('users')->onDelete('restrict');
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
