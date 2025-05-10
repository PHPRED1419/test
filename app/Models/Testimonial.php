<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_testimonial';
    protected $primaryKey = 'testimonial_id';
    protected $fillable = [
        'testimonial_id', 'title', 'name', 'photo', 'email', 'description', 'status', 'created_at', 'updated_at', 'deleted_at'
    ];
}
