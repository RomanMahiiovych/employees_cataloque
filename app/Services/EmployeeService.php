<?php


namespace App\Services;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Faker\Generator as Faker;

class EmployeeService
{
    public function make(EmployeeRequest $request, Faker $faker)
    {
        $employee = Employee::create([
//                'type_photo' => $request->type_photo,
            'name' => $request->name,
            'position' => $request->position,
            'date_of_employment' => $request->date_of_employment,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'salary' => "$request->salary",
//                'head'  => $request->head,
            'admin_created_id' => $faker->unique()->randomNumber(6),
            'admin_updated_id' => $faker->unique()->randomNumber(6)
        ]);

        return $employee;
    }
}
