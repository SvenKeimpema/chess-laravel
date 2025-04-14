<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MatchmakingController;
use App\Http\Controllers\PieceImageController;
use App\Http\Controllers\MoveController;
use App\Http\Controllers\PieceMovement\GameStatus;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// we do some Inertia::render inside of here since they don't have any other kind of functionality
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('welcome');
    })->name('home');
    Route::get('/matchmaking', [MatchmakingController::class,'index'])->name('api.game.matchmaking');
    Route::get('/play/human', function () {
        return Inertia::render('game/human-match');
    })->name('api.game.human');
    Route::get('/api/current-game', [GameController::class, 'current_game'])->name('api.game.current');
    Route::get('/api/board/data', [BoardController::class, 'get'])->name('api.board.data');
    Route::get('/api/board/status', [GameStatus::class, 'status'])->name('api.board.status');

    Route::post('/api/piece/images', [PieceImageController::class, 'index'])->name('api.piece.image');

    Route::get('/api/moves/get', [MoveController::class, 'get'])->name('api.moves.get');
    Route::post("/api/moves/make", [MoveController::class, 'make'])->name('api.moves.make');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
