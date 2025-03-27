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
        Schema::create('matchmaking', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->references("id")->on("users");
            $table->foreignId("game_id")->nullable()->references("id")->on("game");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matchmaking');
    }
};
