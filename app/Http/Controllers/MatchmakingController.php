<?php

namespace App\Http\Controllers;

use App\Events\PlayerJoinedGame;
use App\Models\Game;
use App\Models\Matchmaking;
use App\Models\UserGames;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * This is the controller that will handle people joining matches and allows us to create some form of 1v1 multiplayer chess match
 * However please note that this matchmaking controller does not use any kind of checking on how good someone is, with this anybody can join anybody
 */
class MatchmakingController extends Controller
{
    private BoardController $board;

    private GameController $game;

    public function __construct()
    {
        $this->board = new BoardController;
        $this->game = new GameController;
    }

    /**
     * This function will join or create a match based on if there is a match for us to actually join.
     * This function will also send a message to the other user if the match is created and for him to 'join' the game(this basically just means
     * he needs to change the view to the game board)
     */
    public function index(): \Inertia\Response|\Illuminate\Http\RedirectResponse
    {
        // if we are already matchmaking or inside a game we should not redo the matchmaking process
        $current_match_state = $this->get_match_state();
        switch ($current_match_state) {
            case MatchState::PENDING:
                return Inertia::render('matchmaking/wait-screen');
            case MatchState::FOUND:
                return redirect('/play/human');
        }

        $game_id = $this->find_match();

        // no match found so we should find a new one
        if (! $game_id) {
            $this->create_join_matchmaking();
            $game_id = $this->find_match();
            $this->board->create($game_id);

            return Inertia::render('matchmaking/wait-screen');
        }

        // match found we can add the players to the user_games and remove them from matchmaking
        $this->matchmaking_to_game($game_id);

        // in the chess game there should be a random side they are on
        $this->game->create_random_side($game_id);

        // now that we are in a game with the other player we should let him know to go to the game board
        PlayerJoinedGame::dispatch($game_id);

        return redirect('/play/human');
    }

    public function leave()
    {
        $matchmaking = Matchmaking::where('user_id', Auth::user()->id)->first();
        if ($matchmaking) {
            Matchmaking::where('id', $matchmaking->id)->delete();
        }
    }

    public function play(): \Inertia\Response|\Illuminate\Http\RedirectResponse
    {
        if ($this->get_match_state() === MatchState::FOUND) {
            return Inertia::render('game/human-match');
        }

        return redirect('/');
    }

    public function ready(): bool
    {
        return $this->get_match_state() === MatchState::FOUND;
    }

    /**
     * return the current state of the match, these state can be NONE where the user isn't matchmaking or is inside a match, PENDING: the user is matchmaking
     * but no one else is connected to the match and there is FOUND where there is someone else connected to the match.
     */
    private function get_match_state(): MatchState
    {
        // try to find a game of the user that has not ended yet
        $game = UserGames::where(['user_id' => Auth::user()->id,
            'ended' => false])->first();
        if ($game) {
            return MatchState::FOUND;
        }

        $match = Matchmaking::where('user_id', Auth::user()->id)->first();
        if (! $match) {
            return MatchState::NONE;
        }

        // check if there is only one person connected to the game
        $connected_user_count = Matchmaking::where('game_id', $match->game_id)->count();
        if ($connected_user_count == 1) {
            return MatchState::PENDING;
        }

        // this should be unreachable, if this gets reached something went wrong
        error_log('Something went wrong during matchmaking, no game for the user created but there are multiple people in matchmaking(same game)');

        return MatchState::NONE;
    }

    /**
     * returns true if we are currently inside a match
     */
    private function existing_match(): bool
    {
        $matchmaking = Matchmaking::where('user_id', Auth::user()->id)->first();

        return $matchmaking != null;
    }

    /**
     * will return the id of the match if we can find one else we will just return
     */
    private function find_match(): ?int
    {
        $match = Matchmaking::select('game_id', 'user_id')
            ->groupBy('game_id')
            ->havingRaw('COUNT(user_id) = 1')
            ->first();

        return $match ? $match->game_id : null;
    }

    /**
     * returns a error if we failed to join the match, since we should not be able to access this function before we are elegible to actually find the match.
     *
     * @param  int  $game_id
     */
    private function matchmaking_to_game($game_id): void
    {
        $other_user_id = Matchmaking::where('game_id', $game_id)
            ->where('user_id', '!=', Auth::user()->id)
            ->first()
            ->user_id;

        Matchmaking::where(['game_id' => $game_id])->delete();

        UserGames::create([
            'game_id' => $game_id,
            'user_id' => $other_user_id,
            'ended' => false,
        ]);

        UserGames::create([
            'game_id' => $game_id,
            'user_id' => Auth::user()->id,
            'ended' => false,
        ]);

    }

    /**
     * this function will create a match which other people can join, this function will also make it so we join the created match/game
     */
    private function create_join_matchmaking(): void
    {
        // we want to simply create a game here and add the user to the matchmaking table, the game table will not need any parameters since of how are schema works
        $game = Game::create([]);
        Matchmaking::create([
            'game_id' => $game->id,
            'user_id' => Auth::user()->id,
        ]);
    }
}

enum MatchState
{
    case NONE;
    case PENDING;
    case FOUND;
}
