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
            $table->foreignUuid('monthly_tender_id')->constrained()->cascadeOnDelete();
            $table->string('tender_name');
            $table->bigInteger('tender_fees');
            $table->bigInteger('bid_security')->default(0);
            $table->bigInteger('other_fees')->default(0);
            $table->text('description');
            $table->string('organisation_name');
            $table->date('opening_date');
            $table->date('closing_date')->nullable();
            $table->json('documents')->nullable();
            $table->foreignUuid('stored_by')->constrained('users')->onDelete('restrict');
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
