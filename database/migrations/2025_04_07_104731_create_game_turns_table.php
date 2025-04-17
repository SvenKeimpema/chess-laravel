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
        Schema::create('game_turns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('game_id')->references('id')->on('game');
            $table->foreignId('turn')->references('id')->on('users');
            $table->boolean('side');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_turns');
    }
};
