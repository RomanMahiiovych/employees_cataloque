<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'photo',
        'small_photo',
        'type_photo',
        'name',
        'position',
        'date_of_employment',
        'phone_number',
        'email',
        'salary',
        'head',
        'admin_created_id',
        'admin_updated_id'
    ];

//    protected $dates = ['date_of_employment'];

    public function heads()
    {
        return $this->belongsToMany(Employee::class, 'employee_head', 'head_id', 'employee_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_head', 'employee_id', 'head_id');
    }

    public function employeeName()
    {
        return $this->belongsToMany(Employee::class,
                                        'employee_head',
                                'employee_id',
                                'head_id')
                                        ->withoutPivot
                                        ->limit(1);
    }

    public function getSalaryAttribute(){
        if(!$this->attributes['salary']){
            return null;
        }

        return  '$'.$this->attributes['salary'];
    }

    public function getDateOfEmploymentAttribute($value){
        if(!$this->attributes['date_of_employment']){
            return null;
        }

        return  Carbon::parse($this->attributes['date_of_employment'])->format('d.m.y');
    }
}
