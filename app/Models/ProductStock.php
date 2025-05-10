<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'wl_product_stock';
    protected $fillable = ['product_id', 'product_color','product_size','product_price','product_discounted_price','product_discount_percent','product_quantity','used_quantity','inventory','select_status']; 
    // Adjust based on your table structure

    // Relationship with Size model
    public function size()
    {
        return $this->belongsTo(Size::class, 'product_size', 'size_id');
    }

    // Relationship with Color model
    public function color()
    {
        return $this->belongsTo(Color::class, 'product_color', 'color_id');
    }
}
