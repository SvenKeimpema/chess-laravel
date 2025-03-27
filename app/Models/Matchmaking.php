<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matchmaking extends Model {
    protected $table = "matchmaking";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        "game_id",
        "user_id"
    ];
}