<?php

namespace App\Http\Controllers\PieceMovement\Math;

/**
 * Class BlockersAndEnemiesCalculator
 *
 * This class provides methods to calculate blockers and enemies from bitboards.
 */
class BlockersAndEnemiesCalculator {

    /**
     * Calculate the blockers bitboard from an array of bitboards.
     *
     * @param array $bbs An array of bitboards representing different pieces.
     * @return int The bitboard representing all blockers.
     */
    public static function get_blockers(array $bbs): int {
        $starting_piece = 0;
        $ending_piece = 6;
        $blockers = 0;

        for($piece = $starting_piece; $piece < $ending_piece; $piece++) {
            $blockers |= $bbs[$piece];
        }

        return $blockers;
    }

    /**
     * Calculate the enemies bitboard from an array of bitboards.
     *
     * @param array $bbs An array of bitboards representing different pieces.
     * @return int The bitboard representing all enemies.
     */
    public static function get_enemies(array $bbs): int {
        $starting_piece = 6;
        $ending_piece = 12;
        $enemies = 0;

        for($piece = $starting_piece; $piece < $ending_piece; $piece++) {
            $enemies |= $bbs[$piece];
        }

        return $enemies;
    }
}
