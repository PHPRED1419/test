<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ApplicationMedia;
use App\Models\ApplicationsCategories;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $table = 'wl_applications';
    protected $primaryKey = 'applications_id';
    protected $guarded = [];

    public function media()
    {
        return $this->hasMany(ApplicationMedia::class, 'applications_id');
    }

    public function defaultMedia()
    {
        return $this->hasOne(ApplicationMedia::class, 'applications_id')
                    ->where('is_default', 'Y');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(\Modules\Category\Entities\ApplicationsCategories::class, 'category_id');
    }
   
}
