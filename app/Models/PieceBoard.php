<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $board
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard whereBoard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PieceBoard extends Model
{
    protected $table = 'piece_board';

    protected $primaryKey = 'id';

    protected $fillable = ['game_id', 'piece', 'board'];

    public $incrementing = true;

    public $timestamps = true;
}
