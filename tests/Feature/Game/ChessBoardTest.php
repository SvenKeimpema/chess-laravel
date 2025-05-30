<?php

use App\Http\Controllers\PieceImageController;
use PHPUnit\Framework\Assert as PHPUnit;

test('all piece images are present', function () {
    $pieceImageController = new PieceImageController;
    // we expect there to be 12 images(6 images per side on the chess board)
    PHPUnit::assertTrue(count($pieceImageController->index()) == 12);
});
