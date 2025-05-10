<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Category; 
use App\Models\ApplicationsCategories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path('Helpers/CategoryHelper.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Share category data with all views (if needed)
        view()->share([
            'category_data' => Category::where('status', '1')
                                          ->where('parent_category_id',null)
                                          ->orderBy('name')
                                          ->get()							
        ]);
        
       
    
    }
}
