<?php

namespace App\Http\Controllers\PieceMovement\Math;

use App\Http\Controllers\GameController;


/**
 * Class BlockersAndEnemiesCalculator
 *
 * This class provides methods to calculate blockers and enemies from bitboards.
 */
class BlockersAndEnemiesCalculator {
    private GameController $game_controller;

    function __construct()
    {
        $this->game_controller = new GameController();
    }

    /**
     * Calculate the blockers bitboard from an array of bitboards.
     *
     * @param array $bbs An array of bitboards representing different pieces.
     * @return int The bitboard representing all blockers.
     */
    public function get_blockers(array $bbs): int {
        $side = $this->game_controller->current_side();

        $starting_piece = $side ? 0 : 6;
        $ending_piece = $side ? 6 : 12;
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
    public function get_enemies(array $bbs): int {
        $side = $this->game_controller->current_side();

        $starting_piece = $side ? 6 : 0;
        $ending_piece = $side ? 12 : 6;
        $enemies = 0;

        for($piece = $starting_piece; $piece < $ending_piece; $piece++) {
            $enemies |= $bbs[$piece];
        }

        return $enemies;
    }
}
