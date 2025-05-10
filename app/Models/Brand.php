<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_brands';
    protected $primaryKey = 'brand_id';
    protected $fillable = [
        'brand_id', 'brand_name', 'slug', 'brand_url', 'brand_image', 'created_at', 'updated_at', 'deleted_at', 'sort_order', 'status'
    ];
}
