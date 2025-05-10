<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flashe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_flashes';
    protected $primaryKey = 'flash_id';
    protected $fillable = [
        'flash_id', 'flash_image', 'flash_url', 'flash_title', 'created_at', 'updated_at', 'deleted_at', 'sort_order', 'status'
    ];
}
