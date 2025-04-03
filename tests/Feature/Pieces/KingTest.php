<?php

namespace Tests\Feature\Pieces;

use App\Http\Controllers\PieceMovement\Pieces\King;

test("all king moves generate properly", function() {
    $king = new King();
    $sq = 36;
    $blocks = 0;
    $enemies = 0;
    $correct_moves = [8, -8, 1, -1, 7, -7, 9, -9];
    $validate_moves_bb = 0;

    foreach($correct_moves as $move) {
        $validate_moves_bb |= 1 << ($sq + $move);
    }

    $moves = $king->generateMoves($sq, true, $blocks, $enemies);
    expect($moves)->toBe($validate_moves_bb);
});

test("king can't teleport from the right side of the board to the left", function() {
    $king = new King();
    $sq = 15;
    $blocks = 0;
    $enemies = 0;
    $correct_moves = [8, -8, -1, 7, -9];
    $validate_moves_bb = 0;

    foreach($correct_moves as $move) {
        $validate_moves_bb |= 1 << ($sq + $move);
    }

    $moves = $king->generateMoves($sq, true, $blocks, $enemies);
    expect($moves)->toBe($validate_moves_bb);
});

test("king cannot teleport from the left side of the board to the right", function() {
    $king = new King();
    $sq = 8;
    $blocks = 0;
    $enemies = 0;
    $correct_moves = [8, -8, 1, -7, 9];
    $validate_moves_bb = 0;

    foreach($correct_moves as $move) {
        $validate_moves_bb |= 1 << ($sq + $move);
    }

    $moves = $king->generateMoves($sq, true, $blocks, $enemies);
    expect($moves)->toBe($validate_moves_bb);
});

test("king cannot get outside of the board (sq >= 0 && sq < 64)", function() {
    $king = new King();
    $sq = 0;
    $blocks = 0;
    $enemies = 0;
    $correct_moves = [8, 1, 9];
    $validate_moves_bb = 0;

    foreach($correct_moves as $move) {
        $validate_moves_bb |= 1 << ($sq + $move);
    }

    $moves = $king->generateMoves($sq, true, $blocks, $enemies);
    expect($moves)->toBe($validate_moves_bb);

    $sq = 63;
    $correct_moves = [-8, -1, -9];
    $validate_moves_bb = 0;

    foreach($correct_moves as $move) {
        $validate_moves_bb |= 1 << ($sq + $move);
    }

    $moves = $king->generateMoves($sq, true, $blocks, $enemies);
    expect($moves)->toBe($validate_moves_bb);
});
