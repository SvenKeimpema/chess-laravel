<?php

namespace App\Http\Controllers\PieceMovement;

use App\Http\Controllers\BoardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PieceMovement\Math\BitboardOperations;
use App\Http\Controllers\PieceMovement\Math\BlockersAndEnemiesCalculator;
use App\Http\Controllers\PieceMovement\Pieces\Bishop;
use App\Http\Controllers\PieceMovement\Pieces\King;
use App\Http\Controllers\PieceMovement\Pieces\Knight;
use App\Http\Controllers\PieceMovement\Pieces\Pawn;
use App\Http\Controllers\PieceMovement\Pieces\Rook;

class MoveGenerator {
    private Pawn $pawnGenerator;
    private Knight $knightGenerator;
    private Bishop $bishopGenerator;
    private Rook $rookGenerator;
    private King $kingGenerator;
    private BoardController $boardController;
    private GameController $game_controller;
    private BlockersAndEnemiesCalculator $blockCalculator;

    function __construct() {
        $this->pawnGenerator = new Pawn();
        $this->knightGenerator = new Knight();
        $this->bishopGenerator = new Bishop();
        $this->rookGenerator = new Rook();
        $this->kingGenerator = new King();
        $this->boardController = new BoardController();
        $this->blockCalculator = new BlockersAndEnemiesCalculator();
        $this->game_controller = new GameController();  
    }

    /**
     * Generates all possible moves for all pieces on the board.
     *
     * @param array $board An array of bitboards representing the board state.
     * @return array An array of generated moves.
     */
    function generate_moves(array $board): array {
        $blockers = $this->blockCalculator->get_blockers($board);
        $enemies = $this->blockCalculator->get_enemies($board);
        $moves = [];

        $side = $this->game_controller->current_side();

        $starting_piece = $side ? 0 : 6;
        $ending_piece = $side ? 6 : 12;

        for($piece = $starting_piece; $piece <= $ending_piece; $piece++) {
            $bb = $board[$piece];
            while ($bb !== 0) {
                $sq = BitboardOperations::ls1b($bb);
                switch ($piece) {
                    case 0:
                    case 6:
                        $generated_moves = $this->pawnGenerator->generateMoves($sq, $piece == 0, $blockers, $enemies);
                        break;
                    case 1:
                    case 7:
                        $generated_moves = $this->knightGenerator->generateMoves($sq, true, $blockers, $enemies);
                        break;
                    case 2:
                    case 8:
                        $generated_moves = $this->bishopGenerator->generateMoves($sq, true, $blockers, $enemies);
                        break;
                    case 3:
                    case 9:
                        $generated_moves = $this->rookGenerator->generateMoves($sq, true, $blockers, $enemies);
                        break;
                    case 4:
                    case 10:
                        $generated_moves = $this->bishopGenerator->generateMoves($sq, true, $blockers, $enemies) |
                        $this->rookGenerator->generateMoves($sq, true, $blockers, $enemies);
                        break;
                    case 5:
                    case 11:
                        $generated_moves = $this->kingGenerator->generateMoves($sq, true, $blockers, $enemies);
                        break;
                    default:
                        $generated_moves = [];
                }

                $moves = array_merge($moves, BitboardOperations::bb_to_moves($sq, $generated_moves, $piece));
                $bb ^= (1 << $sq);
            }
        }

        return $moves;
    }
}
