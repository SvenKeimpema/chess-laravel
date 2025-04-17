<?php

namespace App\Http\Controllers\PieceMovement\Pieces;

interface Piece
{
    /**
     * this function will generate all possible moves for a piece, given the current position of the piece
     *
     * @param  int  $sq  the square on the board where the moves will be generated from
     * @param  bool  $side  way the piece is facing and will move(important for pawns, this also determines which pieces are enemies and friends).
     *                      however that will not be generated here. Note that if side is true it will generate the moves for the white pieces
     * @param  int  $blocks  This will not allow the piece to the specific bit on the block
     * @param  int  $enemies  This will allow the piece to capture the specific bit on the block
     */
    public function generateMoves(int $sq, bool $side, int $blocks, int $enemies): int;
}
