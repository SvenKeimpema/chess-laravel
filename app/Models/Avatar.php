<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $id
 * @property int $user_id
 * @property array $Avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereBoard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Avatar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Avatar extends Model
{
    protected $table = "avatars";
    protected $fillable = ["user_id", "avatar"];
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;
}
