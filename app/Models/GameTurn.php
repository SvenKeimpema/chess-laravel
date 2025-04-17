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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTurn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTurn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTurn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTurn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTurn whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTurn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTurn whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTurn whereUserId($value)
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
