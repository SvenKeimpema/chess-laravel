<?php

namespace App\Http\Controllers\PieceMovement;

use App\Http\Controllers\PieceMovement\Filter\KingDangerFilter;
use App\Http\Controllers\PieceMovement\Math\BitboardOperations;
use App\Http\Controllers\PieceMovement\MoveGenerator;
use App\Models\UserGames;
use Auth;
use Illuminate\Http\JsonResponse;

class GameStatus {
    private MoveGenerator $moveGenerator;
    private KingDangerFilter $kingDangerFilter;
    private Board $board;
    private PieceSide $pieceSide;

    function __construct() {
        $this->moveGenerator = new MoveGenerator();
        $this->kingDangerFilter = new KingDangerFilter();
        $this->board = new Board();
        $this->pieceSide = new PieceSide();
    }

    /**
    * Status of the current game, this will be returned with json.
    * 2 of the fields are ["won", "draw"] these 2 have booleans for ofcourse if 1 of these are true
    * the last field it will return the side that has won
    * @return JsonResponse returns a json response with the fields ["won", "draw", "side"]
    **/
    public function status(bool $side): JsonResponse {
        $won = $this->isCheckmate($side);
        $draw = $this->isStalemate($side);
        $name = null;

        if ($won) {
            $name = $side ? 'Black' : 'White';
        }

        return response()->json([
            'win' => $won,
            'draw' => $draw,
            'side' => $name
        ]);
    }

    /**
     * Checks if the current game state is a stalemate.
     *
     * @return bool True if it's a stalemate, false otherwise.
     */
    public function isStalemate(bool $side): bool {
        $bbs = $this->board->get_bbs();
        $moves = $this->moveGenerator->generate_moves($bbs);
        $moves = $this->kingDangerFilter->filter($moves);
        // If there are no legal moves and the current player is not in check, it's a stalemate
        return empty($moves) && !$this->isInCheck($side);
    }

    /**
     * Checks if the current game state is a checkmate.
     *
     * @return bool True if it's a checkmate, false otherwise.
     */
    public function isCheckmate(bool $side): bool {
        $bbs = $this->board->get_bbs();
        $moves = $this->moveGenerator->generate_moves($bbs);
        $moves = $this->kingDangerFilter->filter($moves);

        // If there are no legal moves and the current player is in check, it's a checkmate
        return empty($moves) && $this->isInCheck($side);
    }

    /**
     * Checks if the current player is in check.
     *
     * @param bool current side
     * @return bool True if the current player is in check, false otherwise.
     */
    private function isInCheck(bool $current_side): bool {
        $bbs = $this->board->get_bbs();
        $king_piece = $current_side ? 5 : 11; // White king is 5, Black king is 11
        $king_bb = $bbs[$king_piece];
        $this->pieceSide->switch_side();

        // Check if any opponent piece can attack the king
        $moves = $this->moveGenerator->generate_moves($bbs);
        foreach ($moves as $move) {
            if ($move->end == BitboardOperations::ls1b($king_bb)) {
                $this->pieceSide->switch_side();
                return true;
            }
        }

        $this->pieceSide->switch_side();

        return false;
    }
}
