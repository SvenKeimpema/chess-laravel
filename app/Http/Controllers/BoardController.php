<?php

namespace App\Http\Controllers;

use App\Models\PieceBoard;
use App\Models\UserGames;
use Auth;

class BoardController extends Controller
{
    private GameController $game;

    public function __construct()
    {
        $this->game = new GameController;
    }

    /**
     * Initializes the board state for a new game.
     * Sets up the initial positions of all pieces on the board.
     */
    public function create(int $game_id): void
    {
        $board = [
            [9,  7,  8, 10, 11,  8,  7,  9],
            [6,  6,  6,  6,  6,  6,  6,  6],
            [-1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1],
            [0,  0,  0,  0,  0,  0,  0,  0],
            [3,  1,  2,  4,  5,  2,  1,  3],
        ];

        $piece_boards = [];

        for ($row = 0; $row < 8; $row++) {
            for ($col = 0; $col < 8; $col++) {
                $piece = $board[$row][$col];

                if ($piece == -1) {
                    continue;
                }

                if (! isset($piece_boards[$piece])) {
                    $piece_boards[$piece] = new PieceBoard;
                    $piece_boards[$piece]->game_id = $game_id;
                    $piece_boards[$piece]->piece = $piece;
                }

                $piece_boards[$piece]->board |= 1 << ($row * 8 + $col);
            }
        }

        foreach ($piece_boards as $piece_board) {
            $piece_board->save();
        }
    }

    /**
     * returns a 2D array of the current board state, each piece is represented as a integer on the returned board
     * -1: empty, 0-5: white pieces, 6-11: black pieces
     *
     * @return array 2D array of integers
     */
    public function get(): array
    {
        $game_id = UserGames::where('user_id', Auth::user()->id)->latest()->first()->game_id;
        $piece_boards = PieceBoard::where('game_id', $game_id)->get();
        $board = [];
        for ($row = 0; $row < 8; $row++) {
            $board[$row] = [];
            for ($col = 0; $col < 8; $col++) {
                foreach ($piece_boards as $piece_board) {
                    $bb = $piece_board->board;
                    if (($bb & (1 << ($row * 8 + $col))) !== 0) {
                        $board[$row][$col] = $piece_board->piece;
                        break;
                    }
                }

                if (! isset($board[$row][$col])) {
                    $board[$row][$col] = -1;
                }
            }
        }

        return $board;
    }
}
