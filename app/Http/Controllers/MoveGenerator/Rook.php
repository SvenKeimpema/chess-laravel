<?php

namespace App\Http\Controllers\MoveGenerator;

class Rook implements Piece {
    function generateMoves(int $sq, bool $side, int $blocks, int $enemies): int {
        $bb = 0;
        $r = (int) floor($sq / 8);
        $c = $sq % 8;

        for($row = $r + 1; $row < 8; $row++) {
            $move = 1 << ($row * 8 + $c);
            if(($blocks & $move) !== 0) break;
            $bb |= $move;
            if(($enemies & $move) !== 0) break;
        }

        for($row = $r - 1; $row >= 0; $row--) {
            $move = 1 << ($row * 8 + $c);
            if(($blocks & $move) !== 0) break;
            $bb |= $move;
            if(($enemies & $move) !== 0) break;
        }

        for($col = $c + 1; $col < 8; $col++) {
            $move = 1 << ($r * 8 + $col);
            if(($blocks & $move) !== 0) break;
            $bb |= $move;
            if(($enemies & $move) !== 0) break;
        }

        for($col = $c - 1; $col >= 0; $col--) {
            $move = 1 << ($r * 8 + $col);
            if(($blocks & $move) !== 0) break;
            $bb |= $move;
            if(($enemies & $move) !== 0) break;
        }

        return $bb;
    }
}
