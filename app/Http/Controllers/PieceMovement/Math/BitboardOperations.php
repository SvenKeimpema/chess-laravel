<?php

namespace App\Http\Controllers\PieceMovement\Math;

use App\Http\Controllers\PieceMovement\Move;

/**
 * Class BitboardOperations
 *
 * This class provides operations for bitboard manipulations.
 */
class BitboardOperations
{
    /**
     * Lookup table for de Bruijn sequence method.
     */
    private const INDEX64 = [
        0,  1, 48,  2, 57, 49, 28,  3,
        61, 58, 50, 42, 38, 29, 17,  4,
        62, 55, 59, 36, 53, 51, 43, 22,
        45, 39, 33, 30, 24, 18, 12,  5,
        63, 47, 56, 27, 60, 41, 37, 16,
        54, 35, 52, 21, 44, 32, 23, 11,
        46, 26, 40, 15, 34, 20, 31, 10,
        25, 14, 19,  9, 13,  8,  7,  6,
    ];

    /**
     * De Bruijn sequence constant.
     */
    private const DEBRUIJN64 = 0x03F79D71B4CB0A89;

    /**
     * Find the least significant 1 bit (LS1B) in a bitboard.
     *
     * @param  int  $bb  The bitboard.
     * @return int The index of the least significant 1 bit, or -1 if the bitboard is empty.
     */
    public static function ls1b(int $bb): int
    {
        if ($bb === 0) {
            return -1;
        }
        // Use GMP to handle large integers
        $ls1b = gmp_and($bb, gmp_neg($bb));
        $index = gmp_intval(gmp_div_qr(gmp_mul($ls1b, gmp_init(self::DEBRUIJN64, 16)), gmp_pow(2, 58))[0]) & 0x3F;

        return self::INDEX64[$index];
    }

    /**
     * Convert a bitboard to an array of Move objects.
     *
     * @param  int  $start_sq  The starting square.
     * @param  int  $bb  The bitboard.
     * @param  int  $piece  The piece identifier.
     * @return array An array of Move objects representing the moves.
     */
    public static function bb_to_moves(int $start_sq, int $bb, int $piece): array
    {
        $moves = [];
        for ($sq = 0; $sq < 64; $sq++) {
            if (($bb & (1 << $sq)) !== 0) {
                $moves[] = new Move($start_sq, $sq, $piece);
            }
        }

        return $moves;
    }
}
