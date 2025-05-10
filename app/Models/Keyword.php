<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keyword extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'job_keywords';
    protected $primaryKey = 'kwid';
    protected $fillable = [
        'keywords_name', 'disp_order', 'created_at', 'updated_at', 'deleted_at', 'status'
    ];
}

