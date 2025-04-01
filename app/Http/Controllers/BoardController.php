<?php

namespace App\Http\Controllers;

use App\Models\PieceBoard;

class BoardController extends Controller {
    private MatchmakingController $matchmaking;

    function __construct() {
        $this->matchmaking = new MatchmakingController();
    }

    /**
    * returns a 2D array of the current board state, each piece is represented as a integer on the returned board
    * -1: empty, 0-5: white pieces, 6-11: black pieces
    *
    * @return array 2D array of integers
    */
    public function get(): array {
        $current_game_id = $this->matchmaking->current_game();
        $piece_boards = PieceBoard::where("game_id", $current_game_id)->get();
        $board = [];
        for($row = 0; $row < 8; $row++) {
            $board[$row] = [];
            for($col = 0; $col < 8; $col++) {
                $piece = 0;
                foreach($piece_boards as $piece_board) {
                    $bb = $piece_board->board;
                    if($bb & (1 << ($row * 8 + $col)) != 0) {
                        $board[$row][$col] = $piece_board;
                        break;
                    }
                }

                if(!isset($board[$row][$col])) {
                    $board[$row][$col] = -1;
                }
            }
        }

        return $board;
    }
}
