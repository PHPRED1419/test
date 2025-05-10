<?php

namespace Modules\Pages\Entities;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'wl_pages'; 
    
    protected $fillable = [
        'id', 'title', 'slug', 'description', 
    ];
    
    

}
