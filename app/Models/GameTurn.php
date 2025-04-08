<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $id
 * @property int|null $game_id
 * @property int|null $turn
 * @property bool $side
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matchmaking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matchmaking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matchmaking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matchmaking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matchmaking whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matchmaking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matchmaking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matchmaking whereUserId($value)
 * @mixin \Eloquent
 */
class GameTurn extends Model
{
    protected $table = "game_turns";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        "game_id",
        "turn",
        "side"
    ];
}
