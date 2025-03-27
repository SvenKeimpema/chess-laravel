<?php

use App\Models\Game;
use App\Models\Matchmaking;
use App\Models\User;
use PHPUnit\Framework\Assert as PHPUnit;

test("user creates and joins a game whenever matchmaking starts", function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get("/matchmaking");
    $response->assertStatus(200);
    $match = Matchmaking::where("user_id", $user->id)->first();
    PHPUnit::assertTrue($match != null);
    $game = Game::where("id", $match->game_id)->first();
    PHPUnit::assertTrue($game != null);
});  

test("players can join the same game", function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $response1 = $this->actingAs($user1)->get("/matchmaking");
    $response2 = $this->actingAs($user2)->get("/matchmaking");

    PHPUnit::assertTrue($response1 != null);
    PHPUnit::assertTrue($response2 != null);

    $match_user1 = Matchmaking::where("user_id", $user1->id)->first();
    $match_user2 = Matchmaking::where("user_id", $user2->id)->first();

    PHPUnit::assertTrue($match_user1 != null);
    PHPUnit::assertTrue($match_user2 != null);
    PHPUnit::assertTrue($match_user1->game_id == $match_user2->game_id);

    $redirect_response1 = $this->actingAs($user1)->get("/matchmaking");
    $redirect_response2 = $this->actingAs($user2)->get("/matchmaking");

    $redirect_response1->assertStatus(302);
    $redirect_response2->assertStatus(302);
});

test("we can retrieve the match the player is currently in", function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get("/matchmaking");
    $response->assertStatus(200);
    $current_game_response = $this->actingAs($user)->get("/api/current-game");
    $current_game_response->assertStatus(200);
    $current_match = Matchmaking::where("user_id", $user->id)->first();
    PHPUnit::assertTrue($current_match != null);
    PHPUnit::assertTrue($current_game_response->getContent() == $current_match->game_id);
});