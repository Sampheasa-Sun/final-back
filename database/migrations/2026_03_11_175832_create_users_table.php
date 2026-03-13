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
        // 1. The Unified Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Standardized to 'id' for all apps
            
            // Personal Info (Made nullable so the Frontend registration doesn't break if it only sends email/password)
            $table->string('firstName', 50)->nullable();
            $table->string('lastName', 50)->nullable();
            $table->string('profile_picture_url', 255)->nullable();
            
            // Auth Data
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Standardized to 'password'
            $table->rememberToken();
            
            // Roles & Status (Combined from API and Backend)
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->string('status')->default('active');
            
            // Gamification/Metrics (Combined from API and Backend)
            $table->integer('contributions')->default(0);
            $table->integer('knowledge_points')->default(0);
            $table->integer('helpful_votes')->default(0);
            
            $table->timestamps();
        });

        // 2. Required for standard Laravel Auth (from Frontend/API)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Required for standard Laravel Sessions (from Frontend/API)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
