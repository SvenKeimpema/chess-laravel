<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\MatchmakingController;
use App\Http\Controllers\PieceImageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::post('/api/piece/images', [PieceImageController::class, 'index'])->name('api.piece.image');

Route::middleware('auth')->group(function () {
    Route::get('/matchmaking', [MatchmakingController::class,'index'])->name('api.matchmaking');
    Route::get('/play/human', function () {
        return Inertia::render('game/human-match');
    })->name('api.game.human');
    Route::get('/api/current-game', [MatchmakingController::class, 'current_game'])->name('api.game.current');
    Route::get('/api/board/data', [BoardController::class, 'get'])->name('api.board.data');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
