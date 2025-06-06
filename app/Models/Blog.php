<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_blogs';
    protected $fillable = [
        'id', 'title', 'slug', 'image', 'description', 'meta_description', 'status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'
    ];
}
