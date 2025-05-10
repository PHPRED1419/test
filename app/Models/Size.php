<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_sizes';
    protected $primaryKey = 'size_id';
    protected $fillable = [
        'size_id', 'size_name', 'size_date_added', 'size_date_updated', 'sort_order', 'status', 'deleted_at'
    ];
}
