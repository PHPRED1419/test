<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_colors';
    protected $primaryKey = 'color_id';
    protected $fillable = [
        'color_id', 'color_name', 'color_code', 'created_at', 'updated_at', 'sort_order', 'status', 'deleted_at'
    ];
}
