<?php

namespace App\Http\Controllers\PieceMovement\Filter;

use App\Http\Controllers\PieceMovement\Board;
use App\Http\Controllers\PieceMovement\Math\BitboardOperations;
use App\Http\Controllers\PieceMovement\Move;
use App\Http\Controllers\PieceMovement\MoveGenerator;
use App\Http\Controllers\PieceMovement\MoveMaker;
use App\Http\Controllers\PieceMovement\PieceSide;


/**
* if a move makes the king go into check, or the king stays in check, then we filter out the move
*/
class KingDangerFilter {
    private MoveMaker $moveMaker;
    private MoveGenerator $moveGenerator;
    private Board $board;
    private PieceSide $pieceSide;

    function __construct() {
        $this->moveMaker = new MoveMaker();
        $this->moveGenerator = new MoveGenerator();
        $this->board = new Board();
        $this->pieceSide = new PieceSide();
    }

    public function filter(array $moves): array {
        $valid_moves = [];
        foreach($moves as $move) {
            if($this->isSafeMove($move)) {
                array_push($valid_moves, $move);
            }
        }
        return $valid_moves;
    }

    private function isSafeMove(Move $move): bool {
        $bbs = $this->board->get_bbs();
        $new_bbs = $this->moveMaker->make($move->start, $move->end, $bbs);

        // since making the move doesn't change the side we can do this after making the move
        $side = $this->pieceSide->current_side();
        // Get the king's position for the current side
        $king_bb = $side ? $new_bbs[5] : $new_bbs[11];
        $king_sq = BitboardOperations::ls1b($king_bb);

        // Generate only the moves that can potentially put the king in check
        $opponent_moves = $this->moveGenerator->generate_potential_check_moves($new_bbs, $king_sq, !$side);

        // Check if any opponent move can capture the king
        foreach($opponent_moves as $opponent_move) {
            if($opponent_move->end == $king_sq) {
                return false;
            }
        }

        return true;
    }
}
