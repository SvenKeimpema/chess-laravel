<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {
    protected $table = "game";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;
} 