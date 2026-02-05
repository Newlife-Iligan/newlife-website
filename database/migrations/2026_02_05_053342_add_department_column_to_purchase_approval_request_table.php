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
        Schema::table('purchase_approval_requests', function (Blueprint $table) {
            $table->unsignedInteger('department_id')->nullable();
            $table->string('department_position')->nullable();
            $table->float('total_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_approval_requests', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropColumn('department_position');
            $table->dropColumn('total_amount');
        });
    }
};
