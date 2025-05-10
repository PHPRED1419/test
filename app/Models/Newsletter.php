<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_newsletter';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'email', 'created_at', 'updated_at', 'deleted_at', 'sort_order', 'status'
    ];
}
