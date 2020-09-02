<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{
    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
        $employees = Employee::where('name', 'LIKE', '%'. $term. '%')->get();

        $names = array();
        foreach ($employees as $employee){
            array_push($names, $employee['name']);
        }
        return json_encode($names);

    }
}
