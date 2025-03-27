<?php

use App\Models\Game;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Game.{gameId}', function($user, $gameId) {
    $connected_players = Game::where("game_id", $gameId)->pluck("user_id");

    return $connected_players->contains($user->id);
});