<?php

namespace App\Http\Controllers\PieceMovement;

use App\Http\Controllers\BoardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PieceMovement\Filter\KingDangerFilter;
use App\Http\Controllers\PieceMovement\MoveGenerator;
use Illuminate\Http\JsonResponse;

class GameStatus {
    private GameController $gameController;
    private BoardController $boardController;
    private MoveGenerator $moveGenerator;
    private KingDangerFilter $kingDangerFilter;

    function __construct() {
        $this->gameController = new GameController();
        $this->boardController = new BoardController();
        $this->moveGenerator = new MoveGenerator();
        $this->kingDangerFilter = new KingDangerFilter();
    }

    /**
    * Status of the current game, this will be returned with json.
    * 2 of the fields are ["won", "draw"] these 2 have booleans for ofcourse if 1 of these are true
    * the last field it will return the side that has won
    * @return JsonResponse returns a json response with the fields ["won", "draw", "side"]
    **/
    public function status(): JsonResponse {
        $won = $this->isCheckmate();
        $draw = $this->isStalemate();
        $name = null;

        if ($won) {
            $current_side = $this->gameController->current_side();
            $name = $current_side ? 'Black' : 'White';
        }

        return response()->json([
            'won' => $won,
            'draw' => $draw,
            'side' => $name
        ]);
    }

    /**
     * Checks if the current game state is a stalemate.
     *
     * @return bool True if it's a stalemate, false otherwise.
     */
    public function isStalemate(): bool {
        $bbs = $this->boardController->get_bbs();
        $moves = $this->moveGenerator->generate_moves($bbs);
        $moves = $this->kingDangerFilter->filter($moves);
        // If there are no legal moves and the current player is not in check, it's a stalemate
        return empty($moves) && !$this->isInCheck();
    }

    /**
     * Checks if the current game state is a checkmate.
     *
     * @return bool True if it's a checkmate, false otherwise.
     */
    public function isCheckmate(): bool {
        $bbs = $this->boardController->get_bbs();
        $moves = $this->moveGenerator->generate_moves($bbs);

        // If there are no legal moves and the current player is in check, it's a checkmate
        return empty($moves) && $this->isInCheck();
    }

    /**
     * Checks if the current player is in check.
     *
     * @return bool True if the current player is in check, false otherwise.
     */
    private function isInCheck(): bool {
        $bbs = $this->boardController->get_bbs();
        $current_side = $this->gameController->current_side();
        $king_piece = $current_side ? 5 : 11; // White king is 5, Black king is 11
        $king_bb = $bbs[$king_piece];

        // Check if any opponent piece can attack the king
        foreach ($bbs as $piece => $bb) {
            if (($current_side && $piece >= 6) || (!$current_side && $piece < 6)) {
                $moves = $this->moveGenerator->generate_moves($bbs, $piece);
                foreach ($moves as $move) {
                    if ($move->end == $this->get_square($king_bb)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Gets the square index of a bitboard.
     *
     * @param int $bb The bitboard.
     * @return int The square index.
     */
    private function get_square(int $bb): int {
        for ($i = 0; $i < 64; $i++) {
            if (($bb & (1 << $i)) != 0) {
                return $i;
            }
        }
        return -1;
    }
}
