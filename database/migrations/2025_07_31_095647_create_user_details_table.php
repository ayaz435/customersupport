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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamp('app_last_login_at')->nullable();
            $table->timestamp('app_last_logout_at')->nullable();
            $table->timestamp('app_last_active_at')->nullable();
            $table->timestamp('app_last_left_at')->nullable();
            $table->string('app_last_visited_url')->nullable();

            $table->timestamp('web_last_login_at')->nullable();
            $table->timestamp('web_last_logout_at')->nullable();
            $table->timestamp('web_last_active_at')->nullable();
            $table->timestamp('web_last_left_at')->nullable();
            $table->string('web_last_visited_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
