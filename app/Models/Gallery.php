<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    //
   protected $fillable = [
        'title',
        'category',
        'image',
        'featured',
        'status',
        'sort_order'

    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean'
    ]; 
}
