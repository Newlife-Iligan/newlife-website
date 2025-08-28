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
        Schema::table('nl_finance', function (Blueprint $table) {
            $table->string('releasing_ref_number')->nullable();
            $table->unsignedInteger('returned_amt_receiver')->nullable();
            $table->string('return_ref_number')->nullable();
            $table->string('check_number')->nullable();
            $table->unsignedInteger('account_id')->nullable();
            $table->string('ar_particular')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nl_finance', function (Blueprint $table) {
            //
        });
    }
};
