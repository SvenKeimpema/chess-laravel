<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PieceMovement\MoveGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;

class MoveController {
    private BoardController $boardController;
    private MoveGenerator $moveGenerator;

    function __construct()
    {
        $this->boardController = new BoardController();
        $this->moveGenerator = new MoveGenerator();
    }

    // returns all moves of the current board state
    function get(): JsonResponse {
        $bbs = $this->boardController->get_bbs();
        $moves = $this->moveGenerator->generate_moves($bbs);
        $moves_json = [];
        $idx = 0;

        foreach($moves as $move) {
            $moves_json[$idx] = get_object_vars($move);
            $idx += 1;
        }

        return response()->json($moves_json);
    }
}
