<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PieceMovement\GameStatus;
use App\Http\Controllers\PieceMovement\PieceSide;
use Illuminate\Http\JsonResponse;

class StatusController
{
    private PieceSide $pieceSide;

    private GameStatus $gameStatus;

    public function __construct()
    {
        $this->gameStatus = new GameStatus;
        $this->pieceSide = new PieceSide;
    }

    public function game_status(): JsonResponse
    {
        $side = $this->pieceSide->current_side();

        return $this->gameStatus->status($side);
    }
}
