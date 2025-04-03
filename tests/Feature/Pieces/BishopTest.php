<?php

namespace Tests\Feature\Pieces;

use App\Http\Controllers\PieceMovement\Pieces\Bishop;

test("bishop moves along the right diagnals", function() {
    $bishop = new Bishop();
    $sq = 52;
    $blocks = 0;
    $enemies = 0;
    $correct_moves = [7, 9, -7, -9];
    $moves = $bishop->generateMoves($sq, true, $blocks, $enemies);

    foreach($correct_moves as $move) {
        $ans = (1 << ($sq+$move)) & $moves;
        expect($ans)->toBeGreaterThan(0);
    }
});

test("bishop does all the moves its supposed to do", function() {
    $bishop = new Bishop();
    $sq = 52;
    $blocks = 0;
    $enemies = 0;
    $moves = $bishop->generateMoves($sq, true, $blocks, $enemies);

    $count = 0;
    for($i = 0; $i < 64; $i++) {
        if(($moves & (1 << $i)) !== 0) {
            $count++;
        }
    }

    expect($count)->toBe(9);
});

test("blocks are working for bishop", function() {
    $bishop = new Bishop();
    $sq = 52;
    $blocks = 1 << ($sq-9);
    $enemies = 0;
    $moves = $bishop->generateMoves($sq, true, $blocks, $enemies);

    $count = 0;
    for($i = 0; $i < 64; $i++) {
        if(($moves & (1 << $i)) !== 0) {
            $count++;
        }
    }

    expect($count)->toBe(5);
});
