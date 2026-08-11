<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pooja extends Model
{
    //
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'duration',
        'timings',
        'location',
        'benefits',
        'samagri',
        'process',
        'photo',
        'gallery',
        'is_featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'benefits' => 'array',
        'samagri' => 'array',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'status'  => 'boolean',
        'price' => 'decimal:2',
    ];
}
