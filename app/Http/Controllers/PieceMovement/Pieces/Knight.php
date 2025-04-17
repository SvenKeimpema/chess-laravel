<?php

namespace App\Http\Controllers\PieceMovement\Pieces;

class Knight implements Piece
{
    private int $aFile = 0;

    private int $hFile = 0;

    private int $abFile = 0;

    private int $ghFile = 0;

    public function __construct()
    {
        // Initialize bitboards for file boundaries
        for ($x = 0; $x < 8; $x++) {
            $this->aFile |= 1 << ($x * 8);
            $this->hFile |= 1 << ($x * 8 + 7);
            $this->abFile |= 1 << ($x * 8) | 1 << ($x * 8 + 1);
            $this->ghFile |= 1 << ($x * 8 + 6) | 1 << ($x * 8 + 7);
        }
    }

    /**
     * This function will generate all possible moves for a knight, given the current position of the piece.
     *
     * @param  int  $sq  The square on the board where the moves will be generated from.
     * @param  bool  $side  The side the knight is on. If true, it will generate the moves for the white knight; otherwise, for the black knight.
     * @param  int  $blocks  The bitboard representing all squares occupied by friendly pieces, which the knight cannot move to.
     * @param  int  $enemies  The bitboard representing all squares occupied by enemy pieces, which the knight can potentially capture.
     * @return int The bitboard of all possible moves.
     **/
    public function generateMoves(int $sq, bool $side, int $blocks, int $enemies): int
    {
        $bb = 0;
        if ($this->verifyMove($sq - 6, $blocks, $this->abFile)) {
            $bb |= 1 << ($sq - 6);
        }
        if ($this->verifyMove($sq - 10, $blocks, $this->ghFile)) {
            $bb |= 1 << ($sq - 10);
        }

        if ($this->verifyMove($sq - 15, $blocks, $this->aFile)) {
            $bb |= 1 << ($sq - 15);
        }
        if ($this->verifyMove($sq - 17, $blocks, $this->hFile)) {
            $bb |= 1 << ($sq - 17);
        }

        if ($this->verifyMove($sq + 6, $blocks, $this->ghFile)) {
            $bb |= 1 << ($sq + 6);
        }
        if ($this->verifyMove($sq + 10, $blocks, $this->abFile)) {
            $bb |= 1 << ($sq + 10);
        }

        if ($this->verifyMove($sq + 15, $blocks, $this->hFile)) {
            $bb |= 1 << ($sq + 15);
        }
        if ($this->verifyMove($sq + 17, $blocks, $this->aFile)) {
            $bb |= 1 << ($sq + 17);
        }

        return $bb;
    }

    /**
     * This function verifies if a move is valid for a knight.
     * It checks if the target square is within the board boundaries,
     * is not occupied by a friendly piece, and is not blocked by file boundaries.
     *
     * @param  int  $sq  The target square to move to.
     * @param  int  $blocks  The bitboard representing all squares occupied by friendly pieces.
     * @param  int  $fileBlock  The bitboard representing file boundaries that the knight cannot cross.
     * @return bool True if the move is valid, false otherwise.
     **/
    public function verifyMove(int $sq, int $blocks, int $fileBlock): bool
    {
        return $sq >= 0 && $sq < 64 && ($blocks & (1 << $sq)) === 0 && ($fileBlock & (1 << $sq)) === 0;
    }
}
