<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'wl_product_colors';
    protected $fillable = ['product_id', 'size_id']; // Adjust based on your table structure
}
