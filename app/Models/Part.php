<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_parts';
    protected $primaryKey = 'part_id';
    protected $fillable = [
        'part_id', 'part_name', 'slug', 'part_url', 'part_image', 'created_at', 'updated_at', 'deleted_at', 'sort_order', 'status'
    ];
}
