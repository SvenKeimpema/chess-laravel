<?php

namespace App\Http\Controllers\PieceMovement;

class Move {
    private int $start;
    private int $end;
    private int $piece;

    function __construct(int $start, int $end, int $piece) {
        $this->start = $start;
        $this->end = $end;
        $this->piece = $piece;
    }
}
