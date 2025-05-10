<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    protected $table = 'wl_products_media';
    protected $primaryKey = 'id';
    //protected $guarded = [];
   // protected $fillable = ['id', 'color_id', 'product_id', 'color_status', 'media_type', 'media', 'is_default', 'sort_order', 'created_at','updated_at'];

   protected $guarded = [];
    
}
