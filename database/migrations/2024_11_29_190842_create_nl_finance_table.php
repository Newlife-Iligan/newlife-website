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
        Schema::create('nl_finance', function (Blueprint $table) {
            $table->id();
            $table->string('form_type');
            $table->string('cv_number')->nullable();
            $table->date('cv_date')->nullable();
            $table->string('cv_address')->nullable();
            $table->string('cv_particular')->nullable();
            $table->float('cv_amount')->nullable();
            $table->string('mode_of_releasing')->nullable();
            $table->float('cv_amount_actual')->nullable();
            $table->float('cv_amount_returned')->nullable();
            $table->string('mode_of_returning')->nullable();
            $table->unsignedInteger('department')->nullable();
            $table->unsignedInteger('cv_received_by')->nullable();
            $table->unsignedInteger('cv_disbursed_by')->nullable();
            $table->unsignedInteger('cv_approved_by')->nullable();
            $table->string('cv_status')->nullable();
            $table->string('cv_or_number')->nullable();
            $table->string('ar_number')->nullable();
            $table->string('ar_amount_in_words')->nullable();
            $table->string('ar_amount_in_figures')->nullable();
            $table->date('ar_date')->nullable();
            $table->unsignedInteger('ar_received_by')->nullable();
            $table->unsignedInteger('ar_disbursed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nl_finance');
    }
};
