<?php

namespace Modules\Aproduct\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\ApplicationMedia;
use App\Models\ApplicationsCategories;

class Aproduct extends Model
{
    protected $table = 'wl_applications';     
    protected $primaryKey = 'applications_id'; 
    public $timestamps = false; 
    
    public function media()
    {
        return $this->hasMany(ApplicationMedia::class, 'applications_id');
    }
    

}
