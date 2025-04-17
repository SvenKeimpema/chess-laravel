<?php

namespace Tests\Feature\Pieces;

use App\Http\Controllers\PieceMovement\Pieces\Knight;

test('knight generates correct moves from center of the board', function () {
    $knight = new Knight;
    $sq = 36;
    $blocks = 0;
    $enemies = 0;

    $moves = $knight->generateMoves($sq, true, $blocks, $enemies);
    $correct_moves = [6, 10, 15, 17, -6, -10, -15, -17];
    $validate_moves_bb = 0;
    foreach ($correct_moves as $move) {
        $validate_moves_bb |= 1 << ($sq + $move);
    }

    expect($moves)->toBe($validate_moves_bb);
});

test('knight generates correct moves from corner of the board', function () {
    $knight = new Knight;
    $sq = 0;
    $blocks = 0;
    $enemies = 0;

    $moves = $knight->generateMoves($sq, true, $blocks, $enemies);
    $expectedMoves = (1 << 17) | (1 << 10);
    expect($moves)->toBe($expectedMoves);
});

test('knight does not move into blocking piece', function () {
    $knight = new Knight;
    $sq = 36;
    $blocks = (1 << 53) | (1 << 51);
    $enemies = 0;

    $moves = $knight->generateMoves($sq, true, $blocks, $enemies);
    $correct_moves = [6, 10, -6, -10, -15, -17];
    $validate_moves_bb = 0;
    foreach ($correct_moves as $move) {
        $validate_moves_bb |= 1 << ($sq + $move);
    }

    expect($moves)->toBe($validate_moves_bb);
});

test('knight can capture enemy piece', function () {
    $knight = new Knight;
    $sq = 36;
    $blocks = 0;
    $enemies = (1 << 53) | (1 << 51);

    $moves = $knight->generateMoves($sq, true, $blocks, $enemies);

    $correct_moves = [6, 10, 15, 17, -6, -10, -15, -17];
    $validate_moves_bb = 0;
    foreach ($correct_moves as $move) {
        $validate_moves_bb |= 1 << ($sq + $move);
    }

    expect($moves)->toBe($validate_moves_bb);
});

test('knight does not jump to invalid squares', function () {
    $knight = new Knight;
    $sq = 1;
    $blocks = 0;
    $enemies = 0;

    $moves = $knight->generateMoves($sq, true, $blocks, $enemies);
    $expectedMoves = (1 << 16) | (1 << 18) | (1 << 11);
    expect($moves)->toBe($expectedMoves);
});
