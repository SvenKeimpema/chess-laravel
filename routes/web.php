<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MatchmakingController;
use App\Http\Controllers\PieceImageController;
use App\Http\Controllers\MoveController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\AvatarController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\PieceMovement\PieceSide;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// we do some Inertia::render inside of here since they don't have any other kind of functionality
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('welcome');
    })->name('home');
    Route::get('/matchmaking', [MatchmakingController::class, 'index'])->name('api.matchmaking');
    Route::get('/api/game/ready', [MatchmakingController::class, 'ready'])->name('api.matchmaking.ready');
    Route::get('/play/human', [MatchmakingController::class, 'play'])->name('api.matchmaking.human');
    Route::post('/api/leave-matchmaking', [MatchmakingController::class, 'leave'])->name('api.matchmaking.leave');

    Route::get('/api/current-game', [GameController::class, 'current_game'])->name('api.game.current');
    Route::post('/api/end-game', [GameController::class, 'end_game'])->name('api.game.leave');
    Route::get("/api/game/names", [GameController::class, 'get_player_names'])->name('api.game.player.names');


    Route::get('/api/board/data', [BoardController::class, 'get'])->name('api.board.data');
    Route::get('/api/board/status', [StatusController::class, 'game_status'])->name('api.board.status');

    Route::post('/api/piece/images', [PieceImageController::class, 'index'])->name('api.piece.image');

    Route::get('/api/moves/get', [MoveController::class, 'get'])->name('api.moves.get');
    Route::post("/api/moves/make", [MoveController::class, 'make'])->name('api.moves.make');

    Route::get('/api/current-side', [PieceSide::class, 'current_side'])->name('api.current.side');

    Route::get('/profile', function () {
            return Inertia::render('profile');
        })->name('user.profile');

    Route::post('/user/profile', [ProfileController::class, "updateProfile"])->name('user.profile.update');

    Route::get('/user/avatar', [AvatarController::class, "getAvatar"])->name('user.avatar');
    Route::post('/user/avatar', [AvatarController::class, "uploadAvatar"])->name('user.avatar.upload');

    Route::get('/user/profile/username', [UserController::class, "getUsername"])->name('user.profile.username');
    Route::post('/user/profile/username', [UserController::class, "updateUsername"])->name('user.profile.username.update');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
