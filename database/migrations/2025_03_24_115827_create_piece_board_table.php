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
        // creates a bitboard for each piece in a game, this does require us to store quite a lot of data however this will make performace stay pretty good
        Schema::create('piece_board', function (Blueprint $table) {
            $table->id();
            $table->foreign('id', "game_id")->references('id')->on('game');
            $table->integer('board')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piece_board');
    }
};
