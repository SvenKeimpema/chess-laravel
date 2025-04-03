<?php

namespace App\Http\Controllers;

use App\Models\PieceBoard;

class BoardController extends Controller {
    private GameController $game;

    function __construct() {
        $this->game = new GameController();
    }

    public function create(): void {
        $current_game_id = $this->game->current_game();
        $board = [
            [ 9,  7,  8, 10, 11,  8,  7,  9],
            [ 6,  6,  6,  6,  6,  6,  6,  6],
            [-1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1],
            [ 0,  0,  0,  0,  0,  0,  0,  0],
            [ 3,  1,  2,  4,  5,  2,  1,  3]
        ];

        for($row = 0; $row < 8; $row++) {
            for($col = 0; $col < 8; $col++) {
                $piece = $board[$row][$col];

                if($piece == -1) {
                    continue;
                }

                $piece_board = new PieceBoard();

                $piece_board->game_id = $current_game_id;
                $piece_board->board = 1 << ($row * 8 + $col);
                $piece_board->piece = $piece;
                $piece_board->save();
            }
        }
    }

    /**
    * returns a 2D array of the current board state, each piece is represented as a integer on the returned board
    * -1: empty, 0-5: white pieces, 6-11: black pieces
    *
    * @return array 2D array of integers
    */
    public function get(): array {
        $current_game_id = $this->game->current_game();
        $piece_boards = PieceBoard::where("game_id", $current_game_id)->get();
        $board = [];
        for($row = 0; $row < 8; $row++) {
            $board[$row] = [];
            for($col = 0; $col < 8; $col++) {
                foreach($piece_boards as $piece_board) {
                    $bb = $piece_board->board;
                    if(($bb & (1 << ($row * 8 + $col))) !== 0) {
                        $board[$row][$col] = $piece_board->piece;
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

    /**
    * Returns an array of bitboards representing the current board state.
    * Each bitboard corresponds to a specific piece type, where each bit
    * in the bitboard represents the presence of that piece on the board.
    *
    * The array indices represent the piece types:
    * 0-5: white pieces (pawn, knight, bishop, rook, queen, king)
    * 6-11: black pieces (pawn, knight, bishop, rook, queen, king)
    *
    * @return array An array of 12 integers, each representing a bitboard
    *               for a specific piece type.
    */
    public function get_bbs(): array {
        $current_game_id = $this->game->current_game();
        $piece_boards = PieceBoard::where("game_id", $current_game_id)->get();
        $board = array_fill(0, 12, 0);
        for($row = 0; $row < 8; $row++) {
            $board[$row] = [];
            for($col = 0; $col < 8; $col++) {
                foreach($piece_boards as $piece_board) {
                    $bb = $piece_board->board;
                    if(($bb & (1 << ($row * 8 + $col))) !== 0) {
                        $board[$piece_board->piece] |= (1 << ($row * 8 + $col));
                        break;
                    }
                }
            }
        }

        return $board;
    }
}
