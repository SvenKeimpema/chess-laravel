<?php

namespace App\Http\Controllers\PieceMovement\Pieces;

class Bishop implements Piece
{
    public function generateMoves(int $sq, bool $side, int $blocks, int $enemies): int
    {
        $bb = 0;
        $r = (int) floor($sq / 8);
        $c = $sq % 8;

        for ($row = $r + 1, $col = $c + 1; $row < 8 && $col < 8; $row++, $col++) {
            $move = 1 << ($row * 8 + $col);
            if (($blocks & $move) !== 0) {
                break;
            }
            $bb |= $move;
            if (($enemies & $move) !== 0) {
                break;
            }
        }

        for ($row = $r + 1, $col = $c - 1; $row < 8 && $col >= 0; $row++, $col--) {
            $move = 1 << ($row * 8 + $col);
            if (($blocks & $move) !== 0) {
                break;
            }
            $bb |= $move;
            if (($enemies & $move) !== 0) {
                break;
            }
        }

        for ($row = $r - 1, $col = $c + 1; $row >= 0 && $col < 8; $row--, $col++) {
            $move = 1 << ($row * 8 + $col);
            if (($blocks & $move) !== 0) {
                break;
            }
            $bb |= $move;
            if (($enemies & $move) !== 0) {
                break;
            }
        }

        for ($row = $r - 1, $col = $c - 1; $row >= 0 && $col >= 0; $row--, $col--) {
            $move = 1 << ($row * 8 + $col);
            if (($blocks & $move) !== 0) {
                break;
            }
            $bb |= $move;
            if (($enemies & $move) !== 0) {
                break;
            }
        }

        return $bb;
    }
}
