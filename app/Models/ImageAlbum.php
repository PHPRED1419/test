<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageAlbum extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_media_album';
    protected $primaryKey = 'category_id';
    protected $fillable = [  
        'category_id', 'parent_id', 'slug', 'category_name', 'category_image', 'created_at', 'updated_at', 'deleted_at', 'sort_order', 'status', 'is_type'
    ];
}
