<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_banners';
    protected $primaryKey = 'banner_id';
    protected $fillable = [
        'banner_id', 'banner_position', 'banner_image', 'banner_url', 'banner_page', 'banner_title', 'created_at', 'updated_at', 'deleted_at', 'sort_order', 'status'
    ];
}
