<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class videoController extends Controller
{
    //
    public function index(){
        $videos = Video::where('status', true)
            ->orderBy('sort_order','asc')
            ->orderBy('published_at','desc')
            ->get();

        return response()->json([
            'status' => true,
            'video' => $videos,
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
            'video' => $video,
        ],200); 
    }
}
