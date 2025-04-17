<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class PieceImageController extends Controller
{
    /**
     * This function will return all the images of the pieces in the public/images folder
     */
    public function index(): array
    {
        $base64_images = [];
        $images = Storage::disk('public')->allFiles('pieces');

        foreach ($images as $image) {
            // since the url is images/n.png where n is the piece(for example 1.png, 2.png, 3.png, etc)
            // we can get the png name by splitting the url by / and then by .
            // where the first element on the split will be the type of the piece
            $piece_image = explode('/', $image)[1];
            $piece = (int) (explode('.', $piece_image)[0]);
            $base64_images[$piece] = base64_encode(Storage::disk('public')->get($image));
        }

        return $base64_images;
    }
}
