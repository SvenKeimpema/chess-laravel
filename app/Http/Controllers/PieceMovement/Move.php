<?php

namespace App\Http\Controllers\PieceMovement;

class Move
{
    public int $start;

    public int $end;

    public int $piece;

    public function __construct(int $start, int $end, int $piece)
    {
        $this->start = $start;
        $this->end = $end;
        $this->piece = $piece;
    }

    public function __toString(): string
    {
        return ' start: '.$this->start.' end: '.$this->end;
    }
}
