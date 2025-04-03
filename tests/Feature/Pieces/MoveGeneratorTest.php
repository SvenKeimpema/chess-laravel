<?php

namespace Tests\Feature\Pieces;

use App\Http\Controllers\PieceMovement\MoveGenerator;

test("correct amount of moves are generator from default board", function() {
    $bbs = array_fill(0, 12, 0);
    $bbs[0] = 1 << 52;
    $moveGenerator = new MoveGenerator();
    $moves = $moveGenerator->generate_moves($bbs);
    expect(count($moves))->toBe(2);
});
