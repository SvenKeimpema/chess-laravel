<?php

namespace App\Http\Controllers\MoveGenerator;

class King implements Piece {
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
        $bb = 0;
        if($this->verifyMove($sq-8, $blocks, 0)) $bb |= 1 << ($sq - 8);
        if($this->verifyMove($sq+8, $blocks, 0)) $bb |= 1 << ($sq + 8);
        
        if($this->verifyMove($sq-1, $blocks, $this->hFile)) $bb |= 1 << ($sq - 1);
        if($this->verifyMove($sq+1, $blocks, $this->aFile)) $bb |= 1 << ($sq + 1);
        
        if($this->verifyMove($sq-9, $blocks, $this->hFile)) $bb |= 1 << ($sq - 9);
        if($this->verifyMove($sq-7, $blocks, $this->aFile)) $bb |= 1 << ($sq - 7);
        
        if($this->verifyMove($sq+9, $blocks, $this->aFile)) $bb |= 1 << ($sq + 9);
        if($this->verifyMove($sq+7, $blocks, $this->hFile)) $bb |= 1 << ($sq + 7);

        return $bb;
    }

    function verifyMove(int $sq, int $blocks, int $fileBlock): bool {
        return $sq >= 0 && $sq < 64 && ($blocks & (1 << $sq)) === 0 && ($fileBlock & (1 << $sq)) === 0;
    }
}
