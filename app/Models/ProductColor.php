<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = 'wl_product_colors';
    protected $fillable = ['product_id', 'color_id']; // Adjust based on your table structure
}
