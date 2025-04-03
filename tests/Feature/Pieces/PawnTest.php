<?php

namespace Tests\Feature\Pieces;

use App\Http\Controllers\PieceMovement\Pieces\Pawn;

test("pawn generates correct forward moves for white", function () {
    $pawn = new Pawn();
    $sq = 52;
    $side = true;
    $blocks = 0;
    $enemies = 0;

    $moves = $pawn->generateMoves($sq, $side, $blocks, $enemies);
    expect($moves)->toBe(1 << ($sq - 8) | 1 << ($sq - 16));
});

test("pawn generates correct forward moves for black", function () {
    $pawn = new Pawn();
    $sq = 12;
    $side = false;
    $blocks = 0;
    $enemies = 0;

    $moves = $pawn->generateMoves($sq, $side, $blocks, $enemies);
    expect($moves)->toBe(1 << 20);
});

test("pawn does not move forward into blocking piece", function () {
    $pawn = new Pawn();
    $sq = 52;
    $side = true;
    $blocks = 1 << 44;
    $enemies = 0;

    $moves = $pawn->generateMoves($sq, $side, $blocks, $enemies);
    expect($moves)->toBe(0);
});

test("pawn does not move forward into enemy piece", function () {
    $pawn = new Pawn();
    $sq = 52;
    $side = true;
    $blocks = 0;
    $enemies = 1 << 44;

    $moves = $pawn->generateMoves($sq, $side, $blocks, $enemies);
    expect($moves)->toBe(0);
});

test("pawn attacks a enemy piece", function() {
    $pawn = new Pawn();
    $sq = 52;
    $side = true;
    $blocks = 0;
    $enemies = 1 << 43 | 1 << 45;

    $moves = $pawn->generateMoves($sq, $side, $blocks, $enemies);

    // we expect the pawn to be able to move foward and attack the enemy piece
    expect($moves)->toBe(1 << ($sq - 8) | 1 << ($sq - 16) | $enemies);
});

test("piece cannot jump to the other side of the board", function() {
    $pawn = new Pawn();
    $sq = 48;
    $side = true;
    $blocks = 1 << ($sq-8);
    $enemies = 1 << ($sq-9);

    $moves = $pawn->generateMoves($sq, $side, $blocks, $enemies);
    expect($moves)->toBe(0);

    $sq = 48;
    $side = false;
    $blocks = 1 << ($sq+8);
    $enemies = 1 << ($sq+7);

    $moves = $pawn->generateMoves($sq, $side, $blocks, $enemies);

    expect($moves)->toBe(0);
});
