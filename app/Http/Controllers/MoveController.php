<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PieceMovement\Filter\KingDangerFilter;
use App\Http\Controllers\PieceMovement\MoveGenerator;
use App\Http\Controllers\PieceMovement\MoveMaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MoveController {
    private GameController $gameController;
    private BoardController $boardController;
    private MoveGenerator $moveGenerator;
    private MoveMaker $moveMaker;
    private KingDangerFilter $kingDangerFilter;

    function __construct() {
        $this->boardController = new BoardController();
        $this->moveGenerator = new MoveGenerator();
        $this->moveMaker = new MoveMaker();
        $this->gameController = new GameController();
        $this->kingDangerFilter = new KingDangerFilter();

    }

    // Returns all moves of the current board state
    function get(): JsonResponse {
        $bbs = $this->boardController->get_bbs();
        $moves = $this->moveGenerator->generate_moves($bbs);
        $moves = $this->kingDangerFilter->filter($moves);
        $moves_json = [];

        foreach ($moves as $idx => $move) {
            $moves_json[$idx] = get_object_vars($move);
        }

        return response()->json($moves_json);
    }

    /**
     * Makes a move on the chessboard.
     *
     * @param Request $request The HTTP request containing the start and end squares.
     * @return Response The HTTP response indicating the result of the move.
     */
    function make(Request $request): Response {
        if (!$this->gameController->current_turn()) {
            return response(status: 200);
        }

        $start_sq = (int) $request->input("startSquare");
        $end_sq = (int) $request->input("endSquare");

        $this->moveMaker->make($start_sq, $end_sq);

        return response(status: 200);
    }
}
