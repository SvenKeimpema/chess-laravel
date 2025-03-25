<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PieceImageController extends Controller {
    public function index() {
        $base64_images = [];
        $images = Storage::disk("public")->allFiles("images");
        
        foreach ($images as $image) {
            $piece_image = explode("/", $image)[1];
            $piece = (int) (explode(".", $piece_image)[0]);
            $base64_images[$piece] = base64_encode(Storage::disk('public')->get($image));
        }
        
        return $base64_images;
    }
}