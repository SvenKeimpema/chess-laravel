<?php

namespace Tests\Feature;

use App\Models\User;

test("board is correct size", function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $this->actingAs($user1)->get("/matchmaking");
    $this->actingAs($user2)->get("/matchmaking");

    $response = $this->actingAs($user1)->get("/api/board/data");
    $response->assertStatus(200);
    $content = $response->getContent();
    $data = json_decode($content, true);

    // Perform assertions on the array
    expect($data)->toBeArray();
    expect(count($data))->toBe(8);
    expect(count($data[0]))->toBe(8);
});

test("board should contain pieces", function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $this->actingAs($user1)->get("/matchmaking");
    $this->actingAs($user2)->get("/matchmaking");

    $response = $this->actingAs($user1)->get("/api/board/data");
    $response->assertStatus(200);
    $content = $response->getContent();
    $data = json_decode($content, true);

});

