<?php

namespace App\Http\Controllers\MoveGenerator;



class Pawn implements Piece {
    private int $aFile;
    private int $hFile;

    function __construct() {
        $this->aFile = 0;
        $this->hFile = 0;
        for($x = 0; $x < 8; $x++) {
            $this->aFile |= 1 << ($x * 8);
            $this->hFile |= 1 << ($x * 8 + 7);
        }
    }

    function generateMoves(int $sq, bool $side, int $blocks, int $enemies): int {
        return $this->generateFowardMoves($sq, $side, $blocks, $enemies) |
        $this->generateAttackingMoves($sq, $side, $blocks, $enemies);
    }

    /**
    * This function will generate all possible forward moves for a pawn, given the current position of the piece.
    * @param int $sq The square on the board where the moves will be generated from.
    * @param bool $side The side the pawn is on. If true, it will generate the moves for the white pawn; otherwise, for the black pawn.
    * @param int $blocks The bitboard representing all squares occupied by friendly pieces, which the pawn cannot move to.
    * @param int $enemies The bitboard representing all squares occupied by enemy pieces, which the pawn can potentially capture.
    * @return int The bitboard of all possible forward moves.
    **/
    private function generateFowardMoves(int $sq, bool $side, int $blocks, int $enemies): int {
        $bb = 0;
        $blocking_pieces = $blocks | $enemies;
        if($side) {
            // first we want to check if there is a piece on the first square foward
            $move1 = 1 << ($sq - 8);
            if(($blocking_pieces & $move1) !== 0) return $bb;
            $bb |= $move1;

            $move2 = 1 << ($sq - 16);
            if($sq <= 47 || $sq >= 56) return $bb;
            if(($blocking_pieces & $move2) !== 0) return $bb;
            $bb |= $move2;

            return $bb;
        } else {
            $move1 = 1 << ($sq + 8);
            if(($blocking_pieces & $move1) !== 0) return $bb;
            $bb |= $move1;

            $move2 = 1 << ($sq + 16);
            if($sq <= 7 && $sq >= 16) return $bb;
            if(($blocking_pieces & $move2) !== 0) return $bb;
            return $bb;
        }
    }

    /**
    * This function will generate all possible attacking moves for a pawn, given the current position of the piece.
    * @param int $sq The square on the board where the moves will be generated from.
    * @param bool $side The side the pawn is on. If true, it will generate the moves for the white pawn; otherwise, for the black pawn.
    * @param int $blocks The bitboard representing all squares occupied by friendly pieces, which the pawn cannot move to.
    * @param int $enemies The bitboard representing all squares occupied by enemy pieces, which the pawn can potentially capture.
    * @return int The bitboard of all possible attacking moves.
    **/
    private function generateAttackingMoves(int $sq, bool $side, int $blocks, int $enemies): int {
        $bb = 0;

        if($side) {
            $move1 = 1 << ($sq - 9);
            if(($enemies & $move1) !== 0 && ($move1 & $this->hFile) === 0) $bb |= $move1;

            $move2 = 1 << ($sq - 7);
            if(($enemies & $move2) !== 0 && ($move2 & $this->aFile) === 0) $bb |= $move2;
        } else {
            $move1 = 1 << ($sq + 9);
            if(($enemies & $move1) !== 0 && ($move1 & $this->aFile) === 0) $bb |= $move1;

            $move2 = 1 << ($sq + 7);
            if(($enemies & $move2) !== 0 && ($move2 & $this->hFile) === 0) $bb |= $move2;
        }

        return $bb;
    }
}
