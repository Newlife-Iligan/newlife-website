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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->longText('image')->nullable();
            $table->string('name')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('market_value')->nullable();
            $table->string('category')->nullable();
            $table->longText('description')->nullable();
            $table->date('inventory_date')->nullable();
            $table->unsignedInteger('assign_to')->nullable();
            $table->unsignedInteger('counted_by')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_resource');
    }
};
