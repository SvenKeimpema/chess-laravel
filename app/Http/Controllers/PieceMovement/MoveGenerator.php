<?php

namespace App\Http\Controllers\PieceMovement;

use App\Http\Controllers\PieceMovement\Math\BitboardOperations;
use App\Http\Controllers\PieceMovement\Math\BlockersAndEnemiesCalculator;
use App\Http\Controllers\PieceMovement\Pieces\Bishop;
use App\Http\Controllers\PieceMovement\Pieces\King;
use App\Http\Controllers\PieceMovement\Pieces\Knight;
use App\Http\Controllers\PieceMovement\Pieces\Pawn;
use App\Http\Controllers\PieceMovement\Pieces\Rook;

class MoveGenerator
{
    private Pawn $pawnGenerator;

    private Knight $knightGenerator;

    private Bishop $bishopGenerator;

    private Rook $rookGenerator;

    private King $kingGenerator;

    private BlockersAndEnemiesCalculator $blockCalculator;

    private PieceSide $pieceSide;

    public function __construct()
    {
        $this->pawnGenerator = new Pawn;
        $this->knightGenerator = new Knight;
        $this->bishopGenerator = new Bishop;
        $this->rookGenerator = new Rook;
        $this->kingGenerator = new King;
        $this->blockCalculator = new BlockersAndEnemiesCalculator;
        $this->pieceSide = new PieceSide;
    }

    /**
     * Generates all possible moves for all pieces on the board.
     *
     * @param  array  $board  An array of bitboards representing the board state.
     * @return array An array of generated moves.
     */
    public function generate_moves(array $board): array
    {
        $moves = [];
        $side = $this->pieceSide->current_side();
        $starting_piece = $side ? 0 : 6;
        $ending_piece = $side ? 6 : 12;

        for ($piece = $starting_piece; $piece < $ending_piece; $piece++) {
            $bb = $board[$piece];
            while ($bb !== 0) {
                $sq = BitboardOperations::ls1b($bb);
                $generated_moves = $this->generate_moves_for_piece($board, $piece, $side);

                $moves = array_merge($moves, $generated_moves);
                $bb ^= (1 << $sq);
            }
        }

        return $moves;
    }

    public function generate_potential_check_moves(array $board, int $king_sq, bool $side)
    {
        $moves = [];

        $starting_piece = $side ? 0 : 5;
        $ending_piece = $side ? 5 : 11;

        for ($piece = $starting_piece; $piece <= $ending_piece; $piece++) {
            $bb = $board[$piece];
            while ($bb !== 0) {
                $sq = BitboardOperations::ls1b($bb);
                $generated_moves = $this->generate_moves_for_piece($board, $piece, $side);
                foreach ($generated_moves as $move) {
                    if ($move->end == $king_sq) {
                        $moves[] = $move;
                    }
                }

                $bb ^= (1 << $sq);
            }
        }

        return $moves;
    }

    /**
     * Generates all possible moves for a specific piece on the board.
     *
     * @param  array  $board  The current board state.
     * @param  int  $piece  The piece to generate moves for.
     * @return Move[] An array of generated moves.
     */
    private function generate_moves_for_piece(array $board, int $piece, bool $side): array
    {
        $blockers = $this->blockCalculator->get_blockers($board, $side);
        $enemies = $this->blockCalculator->get_enemies($board, $side);
        $moves = [];

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

        return $moves;
    }

    /**
     * Gets the square index of a bitboard.
     *
     * @param  int  $bb  The bitboard.
     * @return int The square index.
     */
    private function get_square(int $bb): int
    {
        for ($i = 0; $i < 64; $i++) {
            if (($bb & (1 << $i)) != 0) {
                return $i;
            }
        }

        return -1;
    }
}
