<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEnquiry extends Model
{
     protected $table = 'wl_product_enquiry';
     protected $primaryKey = 'id';
     protected $fillable = [   
        'product_id', 
        'product_name',    
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',       
        'deleted_at',
        'updated_by',
        'created_at',
        'updated_at',
        'ip_address',
        'user_agent',
    ];

    public static function subjects()
    {
        $subjects = [
            'Services',
            'Cooperation',
            'Advertisement',
            'Other questions'
        ];
        return $subjects;
    }
}
