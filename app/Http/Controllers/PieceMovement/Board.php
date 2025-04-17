<?php

namespace App\Http\Controllers\PieceMovement;

use App\Models\PieceBoard;
use App\Models\UserGames;
use Auth;

class Board {
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
        $game_id = UserGames::where("user_id", Auth::user()->id)->latest()->first()->game_id;
        $piece_boards = PieceBoard::where("game_id", $game_id)->get();

        $board = array_fill(0, 12, 0);

        for($row = 0; $row < 8; $row++) {
            for($col = 0; $col < 8; $col++) {
                foreach($piece_boards as $piece_board) {
                    $bb = $piece_board->board;
                    if(($bb & (1 << ($row * 8 + $col))) !== 0) {
                        $board[$piece_board->piece] |= 1 << ($row * 8 + $col);
                    }
                }
            }
        }

        return $board;
    }
}
