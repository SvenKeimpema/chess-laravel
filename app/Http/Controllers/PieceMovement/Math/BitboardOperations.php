<?php

namespace App\Http\Controllers\PieceMovement\Math;

use App\Http\Controllers\PieceMovement\Move;

/**
 * Class BitboardOperations
 *
 * This class provides operations for bitboard manipulations.
 */
class BitboardOperations {

    /**
     * Find the least significant 1 bit (LS1B) in a bitboard.
     *
     * @param int $bb The bitboard.
     * @return int The index of the least significant 1 bit, or -1 if the bitboard is empty.
     */
    public static function ls1b(int $bb): int {
        for($sq = 0; $sq < 64; $sq++) {
            if(($bb & (1 << $sq)) !== 0) {
                return $sq;
            }
        }
        return -1;
    }

    /**
     * Convert a bitboard to an array of Move objects.
     *
     * @param int $bb The bitboard.
     * @param int $piece The piece identifier.
     * @return array An array of Move objects representing the moves.
     */
    public static function bb_to_moves(int $start_sq, int $bb, int $piece): array {
        $moves = [];
        for($sq = 0; $sq < 64; $sq++) {
            if(($bb & (1 << $sq)) !== 0) {
                $moves[] = new Move($start_sq, $sq, $piece);
            }
        }
        return $moves;
    }
}
