<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Video;

class VideoController extends Controller
{
    //
    public function index(){
        $videos = Video::where('status', true)
            ->orderBy('sort_order','asc')
            ->orderBy('published_at','desc')
            ->get();

        return response()->json([
            'status' => true,
            'videos' => $videos,
        ],200);
    }

    public function show($slug){
        $video = Video::where('slug', $slug)
            ->where('status',true)
            ->first();

        if(!$video){
            return response()->json([
                'status' => false,
                'message' => 'Video not found.',
            ],404);
        }

        return response()->json([
            'status' => true,
            'videos' => $video,
        ],200); 
    }
}
