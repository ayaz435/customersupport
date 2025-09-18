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
        Schema::create('followup6s', function (Blueprint $table) {
            $table->id();
            $table->text('cid');
            $table->text('cname');
            $table->text('task');
            $table->text('priority');
            $table->text('detail');
            $table->text('date');
            $table->text('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followup6s');
    }
};
