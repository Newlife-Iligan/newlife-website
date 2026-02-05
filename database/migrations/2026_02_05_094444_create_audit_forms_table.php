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
        Schema::create('audit_forms', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->json('or_ar_number')->nullable();
            $table->float('actual_amount')->nullable();
            $table->float('return_amount')->nullable();
            $table->float('refunded_amount')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->unsignedBigInteger('audited_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_forms');
    }
};
