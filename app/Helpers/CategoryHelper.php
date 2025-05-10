<?php

use App\Models\Category;
use App\Models\ApplicationsCategories;

if (!function_exists('getSubcategoriesBySlug')) {
    /**
     * Get subcategories by parent category slug
     *
     * @param string $slug Parent category slug
     * @param array $with Relationships to eager load
     * @param int $limit Number of subcategories to return (0 for all)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getSubcategoriesBySlug(string $slug, array $with = [], int $limit = 0)
   {
    try {
        $query = Category::whereHas('parent', function($q) use ($slug) {
                    $q->where('slug', $slug);
                })
                ->with($with)
                ->active()
                ->ordered();
        
        if ($limit > 0) {
            $query->take($limit);
        }
        
        $results = $query->get();
        
        // Debugging output
        logger()->debug('Subcategories Query Results', [
            'slug' => $slug,
            'count' => $results->count(),
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);
        
        return $results;
    } catch (\Exception $e) {
        logger()->error('Error fetching subcategories', ['error' => $e->getMessage()]);
        return collect();
    }
}

function getSubcategoriesByParentSlug(string $slug, array $with = [])
{
    return Cache::remember("subcategories_for_{$slug}", now()->addHours(6), function() use ($slug, $with) {
        // Get parent category ID first
        $parentId = Category::where('slug', $slug)
                          ->value('id');
        
        if (!$parentId) {
            return collect();
        }
        
        // Get all subcategories
        return Category::where('parent_category_id', $parentId)
                     //->active()
                     //->ordered()
                     ->get();
    });
}

function getSubAcategoriesByParentSlug(string $slug, array $with = [])
{
    $parentId = ApplicationsCategories::where('slug', $slug)
                      ->value('id');
    
    if (!$parentId) {
        return collect();
    }
    
    return ApplicationsCategories::where('parent_category_id', $parentId)
                 //->active()
                 //->ordered()
                 ->with($with)  // Added the $with relationship eager loading
                 ->get();
}

}