<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wl_faq';
    protected $primaryKey = 'faq_id';
    protected $fillable = [
        'faq_id', 'faq_question', 'faq_answer', 'sort_order', 'created_at', 'updated_at', 'deleted_at', 'status'
    ];
}
