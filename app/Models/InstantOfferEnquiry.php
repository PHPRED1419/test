<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstantOfferEnquiry extends Model
{
     protected $table = 'wl_instant_offer_enquiry';
     protected $primaryKey = 'id';
     protected $guarded = [];

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
