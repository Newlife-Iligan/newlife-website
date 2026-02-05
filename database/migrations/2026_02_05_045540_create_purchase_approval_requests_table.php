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
        Schema::create('purchase_approval_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->json('items')->nullable();
            $table->string('type')->nullable();
            $table->string('reason')->nullable();
            $table->date('date_required')->nullable();
            $table->unsignedBigInteger('head_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_approval_requests');
    }
};
