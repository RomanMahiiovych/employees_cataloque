<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Position extends Model
{
    protected $table = 'positions';
    protected $fillable = ['name', 'admin_created_id', 'admin_updated_id'];

    public function getDateOfEmploymentAttribute($value){
        if(!$this->attributes['date_of_employment']){
            return null;
        }

        return  Carbon::parse($this->attributes['date_of_employment'])->format('d.m.y');
    }
}

