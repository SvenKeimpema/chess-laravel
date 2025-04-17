<?php

namespace App\Http\Controllers\PieceMovement;

class MoveMaker
{
    private MoveGenerator $moveGenerator;

    private PieceSide $pieceSide;

    private Board $board;

    public function __construct()
    {
        $this->moveGenerator = new MoveGenerator;
        $this->pieceSide = new PieceSide;
        $this->board = new Board;
    }

    public function reset(array $bbs): void
    {
        foreach ($bbs as $piece => $bb) {
            $this->boardController->update($bb, $piece);
        }
        $this->pieceSide->switch_side();
    }

    public function make(int $start_sq, int $end_sq): array
    {
        $bbs = $this->board->get_bbs();

        $start_piece = $this->get_piece_on_square($bbs, $start_sq);
        $end_piece = $this->get_piece_on_square($bbs, $end_sq);

        if ($start_piece == -1) {
            return response(status: 500);
        }

        $bbs = $this->move_piece($bbs, $start_piece, $start_sq, $end_sq);

        if ($end_piece != -1) {
            $bbs = $this->remove_piece($bbs, $end_piece, $end_sq);
        }

        // Check for pawn promotion
        if ($this->is_pawn($start_piece) && $this->is_promotion_square($start_piece, $end_sq)) {
            $bbs = $this->promote_pawn($bbs, $start_piece, $end_sq);
        }

        return $bbs;
    }

    /**
     * returns the current piece that is on the given square, if there is no piece it returns -1
     *
     * @param  $bbs  current board state as a bitboard
     * @param  $sq  square of the piece we want to find
     */
    private function get_piece_on_square(array $bbs, int $sq): int
    {
        for ($piece = 0; $piece < 12; $piece++) {
            if (($bbs[$piece] & (1 << $sq)) !== 0) {
                return $piece;
            }
        }

        return -1;
    }

    /**
     * Moves a piece from the start square to the end square.
     *
     * @param  array  $bbs  The bitboards representing the board state.
     * @param  int  $piece  The piece to move.
     * @param  int  $start_sq  The starting square.
     * @param  int  $end_sq  The ending square.
     */
    private function move_piece(array $bbs, int $piece, int $start_sq, int $end_sq): array
    {
        $piece_bb = $bbs[$piece];
        $piece_bb ^= 1 << $start_sq;
        $piece_bb |= 1 << $end_sq;
        $bbs[$piece] = $piece_bb;

        return $bbs;
    }

    /**
     * Removes a piece from a given square.
     *
     * @param  array  $bbs  The bitboards representing the board state.
     * @param  int  $piece  The piece to remove.
     * @param  int  $square  The square to remove the piece from.
     */
    private function remove_piece(array $bbs, int $piece, int $square): array
    {
        $piece_bb = $bbs[$piece];
        $piece_bb ^= 1 << $square;
        $bbs[$piece] = $piece_bb;

        return $bbs;
    }

    /**
     * Checks if the given piece is a pawn.
     *
     * @param  int  $piece  The piece to check.
     * @return bool True if the piece is a pawn, false otherwise.
     */
    private function is_pawn(int $piece): bool
    {
        // Assuming 0 and 6 are the indices for white and black pawns respectively
        return $piece == 0 || $piece == 6;
    }

    /**
     * Checks if the given square is a promotion square for the given pawn.
     *
     * @param  int  $piece  The pawn piece.
     * @param  int  $square  The square to check.
     * @return bool True if the square is a promotion square, false otherwise.
     */
    private function is_promotion_square(int $piece, int $square): bool
    {
        // Assuming 0-7 are the indices for the 8th rank and 56-63 for the 1st rank
        return ($piece == 0 && $square >= 0 && $square <= 7) || ($piece == 6 && $square >= 56 && $square <= 63);
    }

    /**
     * Promotes a pawn to a queen.
     *
     * @param  array  $bbs  The bitboards representing the board state.
     * @param  int  $pawn  The pawn piece.
     * @param  int  $square  The square where the pawn is promoted.
     */
    private function promote_pawn(array $bbs, int $pawn, int $square): array
    {
        // Remove the pawn from the board
        $bbs = $this->remove_piece($bbs, $pawn, $square);

        // Add a queen to the board
        // Assuming 4 and 10 are the indices for white and black queens respectively
        $queen = $pawn == 0 ? 4 : 10;
        $piece_bb = $bbs[$queen];
        $piece_bb |= 1 << $square;
        $bbs[$queen] = $piece_bb;

        return $bbs;
    }
}
