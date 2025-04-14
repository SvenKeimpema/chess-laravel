<?php

namespace App\Http\Controllers\PieceMovement\Filter;

use App\Http\Controllers\BoardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PieceMovement\Math\BitboardOperations;
use App\Http\Controllers\PieceMovement\Move;
use App\Http\Controllers\PieceMovement\MoveGenerator;
use App\Http\Controllers\PieceMovement\MoveMaker;


/**
* if a move makes the king go into check, or the king stays in check, then we filter out the move
*/
class KingDangerFilter {
    private BoardController $boardController;
    private MoveMaker $moveMaker;
    private MoveGenerator $moveGenerator;
    private GameController $gameController;

    function __construct() {
        $this->boardController = new BoardController();
        $this->moveMaker = new MoveMaker();
        $this->moveGenerator = new MoveGenerator();
        $this->gameController = new GameController();
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
        $bbs = $this->boardController->get_bbs();
        $side = $this->gameController->current_side();

        // Make the move
        $this->moveMaker->make($move->start, $move->end);

        // Generate the new board state
        $new_board = $this->boardController->get_bbs();

        // Get the king's position for the current side
        $king_bb = $side ? $new_board[5] : $new_board[11];
        $king_sq = BitboardOperations::ls1b($king_bb);

        $opponent_moves = $this->moveGenerator->generate_moves($new_board);

        // Check if any opponent move can capture the king
        foreach($opponent_moves as $opponent_move) {
            if($opponent_move->end == $king_sq) {
                // Reset the board state
                $this->moveMaker->reset($bbs);
                return false;
            }
        }

        // Reset the board state
        $this->moveMaker->reset($bbs);
        return true;
    }
}
