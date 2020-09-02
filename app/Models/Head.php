<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Head extends Model
{
    protected $table = 'employee_head';
    public $timestamps = false;
    protected $fillable = [
        'head_id', 'employee_id'
    ];
}
