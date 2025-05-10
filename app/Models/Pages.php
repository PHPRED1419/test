<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_pages';
    protected $fillable = [
        'id', 'title', 'slug', 'image', 'description', 'meta_description', 'status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'
    ];
}
