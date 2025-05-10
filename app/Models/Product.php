<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProductMedia;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductStock;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'wl_products';
    protected $primaryKey = 'products_id';
    protected $guarded = [];

    public function media()
    {
        return $this->hasMany(ProductMedia::class, 'products_id');
    }

    public function defaultMedia()
    {
        return $this->hasOne(ProductMedia::class, 'products_id')
                    ->where('is_default', 'Y');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(\Modules\Category\Entities\Category::class, 'category_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    public function stock()
    {
        return $this->hasOne(ProductStock::class, 'product_id');
    }
}
