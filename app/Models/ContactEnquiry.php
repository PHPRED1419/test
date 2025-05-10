<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
     protected $table = 'wl_enquiry';
     protected $primaryKey = 'id';
     protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'subject',
        'message',
        'status',
        'admin_id',
        'deleted_at',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at'
    ];
    // protected $guarded = [];

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
