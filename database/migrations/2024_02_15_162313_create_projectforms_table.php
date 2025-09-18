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
        Schema::create('projectforms', function (Blueprint $table) {
            $table->id();
            $table->text('cname');
            $table->text('cpname');
            $table->text('ppname');
            $table->text('nic');
            $table->text('ntn');
            $table->text('ctpname');
            $table->text('email');
            $table->text('web');
            $table->text('phone');
            $table->text('mobile');
            $table->text('address');
            $table->text('catagory');
            $table->text('cpabout');
            $table->text('rwebsite');
            $table->text('color');
            $table->text('ywebsite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projectforms');
    }
};
