<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    //
    public function index()
{
    $galleries = Gallery::where('status', true)
        ->orderBy('sort_order', 'asc')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($gallery) {

            $gallery->image_url = $gallery->image
                ? asset('storage/' . $gallery->image)
                : null;

            return $gallery;
        });

    return response()->json([
        'status' => true,
        'gallery' => $galleries,
    ]);
}

    public function show($id)
    {
        $gallery = Gallery::where('status', true)
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'gallery' => $gallery,
        ]);
    }
    }

