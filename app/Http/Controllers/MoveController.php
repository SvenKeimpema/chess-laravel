<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PieceMovement\Board;
use App\Http\Controllers\PieceMovement\Filter\KingDangerFilter;
use App\Http\Controllers\PieceMovement\MoveGenerator;
use App\Http\Controllers\PieceMovement\MoveMaker;
use App\Http\Controllers\PieceMovement\PieceSide;
use App\Models\PieceBoard;
use App\Models\UserGames;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MoveController
{
    private Board $board;

    private MoveGenerator $moveGenerator;

    private MoveMaker $moveMaker;

    private KingDangerFilter $kingDangerFilter;

    private GameController $gameController;

    private PieceSide $pieceSide;

    public function __construct()
    {
        $this->board = new Board;
        $this->moveGenerator = new MoveGenerator;
        $this->moveMaker = new MoveMaker;
        $this->gameController = new GameController;
        $this->kingDangerFilter = new KingDangerFilter;
        $this->pieceSide = new PieceSide;
    }

    // Returns all moves of the current board state
    public function get(): JsonResponse
    {
        $bbs = $this->board->get_bbs();
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
     * @param  Request  $request  The HTTP request containing the start and end squares.
     * @return Response The HTTP response indicating the result of the move.
     */
    public function make(Request $request): Response
    {
        if (! $this->gameController->current_turn()) {
            return response(status: 200);
        }

        $game_id = UserGames::where('user_id', Auth::user()->id)->where('ended', false)->first()->game_id;

        $start_sq = (int) $request->input('startSquare');
        $end_sq = (int) $request->input('endSquare');

        $bbs = $this->moveMaker->make($start_sq, $end_sq);
        $this->pieceSide->switch_side();
        $piece = 0;
        foreach ($bbs as $bb) {
            $this->update_board($game_id, $bb, $piece);
            $piece += 1;
        }

        return response(status: 200);
    }

    /**
     * Updates the board state by setting the bitboard for a specific piece.
     *
     * @param  int  $bb  The bitboard representing the new position of the piece.
     * @param  int  $piece  The piece identifier (0-5 for white pieces, 6-11 for black pieces).
     */
    public function update_board(int $game_id, int $bb, int $piece): void
    {
        PieceBoard::where('piece', $piece)->where('game_id', $game_id)->update(['board' => $bb]);
    }
}
