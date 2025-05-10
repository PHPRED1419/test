<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_video_gallery';
    protected $primaryKey = 'gallery_id';
    protected $fillable = [  
        'gallery_id', 'slug', 'title', 'photo', 'created_at', 'updated_at', 'deleted_at', 'sort_order', 'status'
    ];
}
