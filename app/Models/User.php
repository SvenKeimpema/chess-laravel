<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard whereBoard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PieceBoard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
