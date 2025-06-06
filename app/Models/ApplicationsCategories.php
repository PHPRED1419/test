<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationsCategories extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_applications_categories';
    protected $fillable = [
        'name', 'slug', 'banner_image', 'logo_image', 'description', 'meta_description', 'parent_category_id', 'status', 'enable_bg', 'bg_color', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function parent()
    {
        return $this->belongsTo(applicationsCategories::class, 'parent_category_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class)->where('status', 1);
    }

    public function getChildCategories()
    {
        return $this->hasMany(applicationsCategories::class, 'parent_category_id', 'id')->select('id', 'name', 'slug', 'banner_image');
    }

    public function products()
{
    return $this->hasMany(Product::class, 'category_id'); // Adjust 'category_id' to your actual foreign key
}

    /**
     * getCategories
     *
     * @param integer $status
     * @param string $deleted_at
     * @param integer $parent_category_id
     * @return void
     */
    public static function getCategories($status = 1, $deleted_at = null, $parent_category_id = null)
    {
        $categories = applicationsCategories::where('parent_category_id', $parent_category_id)
            ->where('status', $status)
            ->where('deleted_at', $deleted_at)
            ->select('id', 'name', 'slug', 'banner_image', 'logo_image')
            ->orderBy('priority', 'asc')
            ->get();
        return $categories;
    }

    /**
     * printCategory
     *
     * Prints the category on view directly
     *
     * @param integer $category_id
     * @param integer $layer
     * @return void
     */
    public static function printCategory($category_id = null, $layer = 3)
    {
        $html = "";
        $parentCategories = applicationsCategories::select('id', 'name')->where('parent_category_id', null)->get();

        foreach ($parentCategories as $parent) {
            $selected = ($category_id == $parent->id) ? "selected" : "";
            $html .= "<option value='" . $parent->id . "' " . $selected . ">" . $parent->name . "</option>";

            // Get Sub Categories
            $childCategories = applicationsCategories::select('id', 'name')->where('parent_category_id', $parent->id)->get();
            foreach ($childCategories as $child) {
                $selected = ($category_id == $child->id) ? "selected" : "";
                $html .= "<option value='" . $child->id . "' " . $selected . ">&nbsp;&nbsp;&nbsp;&nbsp;-- " . $child->name . "</option>";

                if ($layer === 3) {
                    // Get Sub Categories 2
                    $childCategories2 = applicationsCategories::select('id', 'name')->where('parent_category_id', $child->id)->get();
                    foreach ($childCategories2 as $child2) {
                        $selected = ($category_id == $child2->id) ? "selected" : "";
                        $html .= "<option value='" . $child2->id . "' " . $selected . ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- " . $child2->name . "</option>";
                    }
                }
            }
        }

        return $html;
    }
}
