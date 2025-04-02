<?php

namespace Tests\Feature\Pieces;

use App\Http\Controllers\MoveGenerator\Rook;

test("check that rook diagnals are set correctly", function() {
    $rook = new Rook();
    $sq = 52;
    $blocks = 0;
    $enemies = 0;
    $correct_moves = [8, -8, 1, -1];
    $moves = $rook->generateMoves($sq, true, $blocks, $enemies);

    foreach($correct_moves as $move) {
        $ans = (1 << ($sq+$move)) & $moves;
        expect($ans)->toBeGreaterThan(0);
    }
});

test("rook does the correct amount of moves", function() {
    $rook = new Rook();
    $sq = 52;
    $blocks = 0;
    $enemies = 0;
    $moves = $rook->generateMoves($sq, true, $blocks, $enemies);

    $count = 0;
    for($i = 0; $i < 64; $i++) {
        if(($moves & (1 << $i)) !== 0) {
            $count++;
        }
    }

    expect($count)->toBe(14);
});

test("blocks are working for rook", function() {
    $rook = new Rook();
    $sq = 52;
    $blocks = 1 << ($sq-8);
    $enemies = 0;
    $moves = $rook->generateMoves($sq, true, $blocks, $enemies);

    $count = 0;
    for($i = 0; $i < 64; $i++) {
        if(($moves & (1 << $i)) !== 0) {
            $count++;
        }
    }

    expect($count)->toBe(8);
});
