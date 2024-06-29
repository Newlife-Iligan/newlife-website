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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->date('birthday')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('facebook_url')->nullable();
            $table->unsignedInteger('ministry_id')->nullable();
            $table->unsignedInteger('life_group_id')->nullable();
            $table->string('address')->nullable();
            $table->longText('profile_pic')->nullable();
            $table->longText('motto')->nullable();
            $table->longText('bible_verse')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
