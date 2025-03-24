<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieceBoard extends Model {
    protected $table = "piece_board";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;
}