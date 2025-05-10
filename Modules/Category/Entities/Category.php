<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'wl_categories';     
    protected $primaryKey = 'id'; 
    public $timestamps = false; 
    
    protected $fillable = [
        // Add your fillable columns here
    ];

    // app/Models/Category.php
/*
public function parent()
{
    return $this->belongsTo(Category::class, 'parent_category_id');
}
*/

public function children()
{
    return $this->hasMany(Category::class, 'parent_category_id');
}
// Define the relationship for subcategories
public function subcategories()
{
    return $this->hasMany(Category::class, 'parent_category_id')->where('status', 1);
}

// Optional: Define inverse relationship
public function parent()
{
    return $this->belongsTo(Category::class, 'parent_category_id');
}

// Optional: Scope for parent categories
public function scopeParentCategories($query)
{
    return $query->whereNull('parent_category_id')->where('status', 1);
}

public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeOrdered($query)
{
    return $query->orderBy('sort_order')->orderBy('name');
}

public function products()
{
    return $this->hasMany(Product::class);
    // OR if you're using a different relationship type:
    // return $this->belongsToMany(Product::class);
}
    

}
