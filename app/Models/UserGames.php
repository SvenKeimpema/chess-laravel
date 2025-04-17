<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $game_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGames newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGames newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGames query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGames whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGames whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGames whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGames whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGames whereUserId($value)
 * @mixin \Eloquent
 */
class UserGames extends Model
{
    protected $table = "user_games";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        "game_id",
        "user_id",
        "ended"
    ];
}
