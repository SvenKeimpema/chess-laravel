<?php

namespace Tests\Feature\Pieces;

use App\Http\Controllers\PieceMovement\MoveGenerator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

test("correct amount of moves are generated from default board", function() {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    Auth::login($user1);

    $this->actingAs($user1)->get("/matchmaking");
    $this->actingAs($user2)->get("/matchmaking");

    $bbs = array_fill(0, 12, 0);
    $bbs[0] = 1 << 52;
    $moveGenerator = new MoveGenerator();
    $moves = $moveGenerator->generate_moves($bbs);
    expect(count($moves))->toBe(2);
});
