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
        Schema::table('user_details', function (Blueprint $table) {

            $table->timestamp('chat_app_last_login_at')->nullable();
            $table->timestamp('chat_app_last_logout_at')->nullable();
            $table->timestamp('chat_app_last_active_at')->nullable();
            $table->timestamp('chat_app_last_left_at')->nullable();
            $table->string('chat_app_last_visited_url')->nullable();

            $table->timestamp('chat_web_last_login_at')->nullable();
            $table->timestamp('chat_web_last_logout_at')->nullable();
            $table->timestamp('chat_web_last_active_at')->nullable();
            $table->timestamp('chat_web_last_left_at')->nullable();
            $table->string('chat_web_last_visited_url')->nullable();

        });
    }

    
};
