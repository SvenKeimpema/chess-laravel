<?php

use App\Http\Controllers\PieceImageController;
use PHPUnit\Framework\Assert as PHPUnit;

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});


test('all piece images are present', function () {
    $pieceImageController = new PieceImageController();
    // we expect there to be 12 images(6 images per side on the chess board)
    PHPUnit::assertTrue(sizeof($pieceImageController->index()) == 12);
});