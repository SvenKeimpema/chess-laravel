<?php

use App\Models\Matchmaking;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Game.{gameId}', function($user, $gameId) {
    error_log($gameId);
    $connected_players = Matchmaking::where("game_id", $gameId)->pluck("user_id");
    error_log("". json_encode($connected_players));
    return $connected_players->contains($user->id);
});