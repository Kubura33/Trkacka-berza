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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->unsignedBigInteger('advertisable_id')->nullable();
            $table->string('title');
            $table->string('home_page')->default('ne');
            $table->string('advertisable_type');
            $table->string('fixed')->default('0');
            $table->string('price');
            $table->string('isSold')->default('0');
            $table->date('lasts_until');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
