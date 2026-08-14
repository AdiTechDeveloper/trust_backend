<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $fillable = [
        'title',
        'slug',
        'category',
        'language',
        'description',
        'video_url',
        'thumbnail',
        'duration',
        'featured',
        'status',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ]; 
}
